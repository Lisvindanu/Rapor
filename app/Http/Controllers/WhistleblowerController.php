<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\PengaduanTerlapor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WhistleblowerController extends Controller
{
    /**
     * Check if user is admin PPKPT and redirect accordingly
     */
    private function checkUserRole()
    {
        $user = Auth::user();
        $selectedRole = session('selected_role');
        $isAdmin = $selectedRole && in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi']);
        
        return $isAdmin;
    }

    /**
     * Dashboard route - redirect based on role
     */
    public function dashboard()
    {
        if ($this->checkUserRole()) {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard();
        }
    }

    /**
     * User Dashboard - untuk pelapor biasa
     * FIXED: Menggunakan manual join untuk kategori
     */
    public function userDashboard()
    {
        $user = Auth::user();
        
        $pengaduan = Pengaduan::where('pengaduan.email_pelapor', $user->email)
            ->with(['terlapor'])
            ->leftJoin('ref_kategori_pengaduan', 'pengaduan.kategori_pengaduan_id', '=', 'ref_kategori_pengaduan.id')
            ->select('pengaduan.*', 'ref_kategori_pengaduan.nama_kategori')
            ->orderBy('pengaduan.created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_pengaduan' => Pengaduan::where('email_pelapor', $user->email)->count(),
            'pending' => Pengaduan::where('email_pelapor', $user->email)->where('status_pengaduan', 'pending')->count(),
            'proses' => Pengaduan::where('email_pelapor', $user->email)->where('status_pengaduan', 'proses')->count(),
            'selesai' => Pengaduan::where('email_pelapor', $user->email)->where('status_pengaduan', 'selesai')->count(),
        ];

        return view('whistleblower.user.dashboard', compact('pengaduan', 'stats'));
    }

    /**
     * Admin Dashboard - untuk admin PPKPT
     * FIXED: Menggunakan manual join untuk kategori
     */
    public function adminDashboard()
    {
        $pengaduan = Pengaduan::with(['terlapor'])
            ->leftJoin('ref_kategori_pengaduan', 'pengaduan.kategori_pengaduan_id', '=', 'ref_kategori_pengaduan.id')
            ->select('pengaduan.*', 'ref_kategori_pengaduan.nama_kategori')
            ->orderBy('pengaduan.created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total_pengaduan' => Pengaduan::count(),
            'pending' => Pengaduan::where('status_pengaduan', 'pending')->count(),
            'proses' => Pengaduan::where('status_pengaduan', 'proses')->count(),
            'selesai' => Pengaduan::where('status_pengaduan', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status_pengaduan', 'ditolak')->count(),
            'butuh_bukti' => Pengaduan::where('status_pengaduan', 'butuh_bukti')->count(),
        ];

        return view('whistleblower.admin.dashboard', compact('pengaduan', 'stats'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        // Cek jika admin, tampilkan pesan error
        $selectedRole = session('selected_role');
        if (in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'])) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Admin tidak dapat membuat pengaduan. Silakan ganti role menjadi mahasiswa atau dosen.');
        }

        // Ambil kategori pengaduan dari tabel ref_kategori_pengaduan
        $kategori = DB::table('ref_kategori_pengaduan')
            ->select('id', 'nama_kategori')
            ->orderBy('nama_kategori', 'asc')
            ->get();
        
        // Debug: cek apakah kategori ada
        if ($kategori->isEmpty()) {
            Log::warning('Kategori pengaduan kosong!');
        } else {
            Log::info('Kategori pengaduan ditemukan: ' . $kategori->count());
        }
        
        $user = Auth::user();
        
        return view('whistleblower.create', compact('kategori', 'user'));
    }

    /**
     * Store new pengaduan with terlapor data
     */
    public function store(Request $request)
    {
        // Cek jika admin, tampilkan pesan error
        $selectedRole = session('selected_role');
        if (in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'])) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Admin tidak dapat membuat pengaduan.');
        }

        try {
            DB::beginTransaction();

            // Validation
            $validated = $request->validate([
                'nama_pelapor' => 'required|string|max:255',
                'kategori_pengaduan_id' => 'required|exists:ref_kategori_pengaduan,id',
                'status_pelapor' => 'required|in:saksi,korban',
                'cerita_singkat_peristiwa' => 'required|string',
                'tanggal_kejadian' => 'nullable|date',
                'lokasi_kejadian' => 'nullable|string|max:255',
                'memiliki_disabilitas' => 'boolean',
                'jenis_disabilitas' => 'nullable|string',
                'alasan_pengaduan' => 'required|array|min:1',
                'evidence_type' => 'required|in:file,gdrive',
                'file_bukti' => 'required_if:evidence_type,file|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
                'evidence_gdrive_link' => 'required_if:evidence_type,gdrive|url',
                'deskripsi_pengaduan' => 'nullable|string',
                'submit_anonim' => 'boolean',
                'terlapor' => 'required|array|min:1',
                'terlapor.*.nama_terlapor' => 'nullable|string|max:255',
                'terlapor.*.status_terlapor' => 'required|in:mahasiswa,pegawai',
                'terlapor.*.nomor_identitas' => 'nullable|string|max:255',
                'terlapor.*.unit_kerja_fakultas' => 'nullable|string|max:255',
                'terlapor.*.kontak_terlapor' => 'required|string|max:255',
                'persetujuan_kebijakan' => 'required|accepted',
            ]);

            $user = Auth::user();
            
            // Handle file upload
            $file_path = null;
            if ($validated['evidence_type'] === 'file' && $request->hasFile('file_bukti')) {
                $file = $request->file('file_bukti');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file_path = $file->storeAs('bukti_pengaduan', $filename, 'public');
            }

            // Handle anonymous submission
            $nama_pelapor = $validated['nama_pelapor'];
            $submit_anonim = $request->boolean('submit_anonim');
            if ($submit_anonim) {
                $nama_pelapor = 'Anonim';
            }

            // Generate kode pengaduan
            $kode_pengaduan = 'WB-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Create pengaduan
            $pengaduan = Pengaduan::create([
                'kode_pengaduan' => $kode_pengaduan,
                'nama_pelapor' => $nama_pelapor,
                'email_pelapor' => $user->email,
                'kategori_pengaduan_id' => $validated['kategori_pengaduan_id'],
                'judul_pengaduan' => 'Pengaduan - ' . substr($validated['cerita_singkat_peristiwa'], 0, 50) . '...',
                'deskripsi_pengaduan' => $validated['deskripsi_pengaduan'],
                'status_pelapor' => $validated['status_pelapor'],
                'cerita_singkat_peristiwa' => $validated['cerita_singkat_peristiwa'],
                'tanggal_kejadian' => $validated['tanggal_kejadian'],
                'lokasi_kejadian' => $validated['lokasi_kejadian'],
                'memiliki_disabilitas' => $request->boolean('memiliki_disabilitas'),
                'jenis_disabilitas' => $validated['jenis_disabilitas'],
                'alasan_pengaduan' => json_encode($validated['alasan_pengaduan']),
                'evidence_type' => $validated['evidence_type'],
                'evidence_path' => $file_path,
                'evidence_gdrive_link' => $validated['evidence_gdrive_link'],
                'status_pengaduan' => 'pending',
                'tanggal_pengaduan' => now(),
                'submit_anonim' => $submit_anonim,
            ]);

            // Create terlapor data
            foreach ($validated['terlapor'] as $terlapor_data) {
                PengaduanTerlapor::create([
                    'pengaduan_id' => $pengaduan->id,
                    'nama_terlapor' => $terlapor_data['nama_terlapor'] ?? 'Tidak disebutkan',
                    'status_terlapor' => $terlapor_data['status_terlapor'],
                    'nomor_identitas' => $terlapor_data['nomor_identitas'],
                    'unit_kerja_fakultas' => $terlapor_data['unit_kerja_fakultas'],
                    'kontak_terlapor' => $terlapor_data['kontak_terlapor'],
                ]);
            }

            DB::commit();

            return redirect()->route('whistleblower.dashboard')
                ->with('success', 'Pengaduan berhasil dikirim dengan kode: ' . $kode_pengaduan . '. Terima kasih atas laporan Anda.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating pengaduan: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat mengirim pengaduan. Silakan coba lagi.');
        }
    }

    /**
     * Show specific pengaduan
     * FIXED: Menggunakan manual join untuk kategori
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['terlapor'])
            ->leftJoin('ref_kategori_pengaduan', 'pengaduan.kategori_pengaduan_id', '=', 'ref_kategori_pengaduan.id')
            ->select('pengaduan.*', 'ref_kategori_pengaduan.nama_kategori')
            ->where('pengaduan.id', $id)
            ->firstOrFail();
        
        // Check authorization
        $user = Auth::user();
        $isAdmin = $this->checkUserRole();
        
        if (!$isAdmin && $pengaduan->email_pelapor !== $user->email) {
            abort(403, 'Anda tidak memiliki akses untuk melihat pengaduan ini.');
        }

        // Parse alasan pengaduan JSON
        $alasan_pengaduan = [];
        if ($pengaduan->alasan_pengaduan) {
            $alasan_pengaduan = json_decode($pengaduan->alasan_pengaduan, true) ?? [];
        }

        return view('whistleblower.show', compact('pengaduan', 'alasan_pengaduan', 'isAdmin'));
    }

    /**
     * Update pengaduan status (admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        if (!$this->checkUserRole()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'status_pengaduan' => 'required|in:pending,proses,selesai,ditolak,butuh_bukti',
            'keterangan_admin' => 'nullable|string',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'status_pengaduan' => $validated['status_pengaduan'],
            'keterangan_admin' => $validated['keterangan_admin'],
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Status pengaduan berhasil diupdate.');
    }

    /**
     * Cancel pengaduan (user only)
     */
    public function cancel($id)
    {
        $user = Auth::user();
        $pengaduan = Pengaduan::where('id', $id)
            ->where('email_pelapor', $user->email)
            ->firstOrFail();

        // Check if pengaduan can be cancelled
        if (!in_array($pengaduan->status_pengaduan, ['pending', 'butuh_bukti'])) {
            return redirect()->back()
                ->with('error', 'Pengaduan tidak dapat dibatalkan pada status ini.');
        }

        $pengaduan->update([
            'status_pengaduan' => 'dibatalkan',
            'keterangan_admin' => 'Dibatalkan oleh pelapor pada ' . now()->format('d/m/Y H:i'),
        ]);

        return redirect()->route('whistleblower.dashboard')
            ->with('success', 'Pengaduan berhasil dibatalkan.');
    }

    /**
     * Download bukti file
     */
    public function downloadBukti($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Check authorization
        $user = Auth::user();
        $isAdmin = $this->checkUserRole();
        
        if (!$isAdmin && $pengaduan->email_pelapor !== $user->email) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh file ini.');
        }

        if (!$pengaduan->evidence_path || !Storage::disk('public')->exists($pengaduan->evidence_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $pengaduan->evidence_path);
        return response()->download($filePath);
    }

    /**
     * API endpoint untuk mendapatkan data pengaduan (untuk DataTables)
     * FIXED: Menggunakan manual join untuk kategori
     */
    public function apiData(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $this->checkUserRole();

        $query = Pengaduan::with(['terlapor'])
            ->leftJoin('ref_kategori_pengaduan', 'pengaduan.kategori_pengaduan_id', '=', 'ref_kategori_pengaduan.id')
            ->select('pengaduan.*', 'ref_kategori_pengaduan.nama_kategori');

        // Filter berdasarkan role
        if (!$isAdmin) {
            $query->where('pengaduan.email_pelapor', $user->email);
        }

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status !== '') {
            $query->where('pengaduan.status_pengaduan', $request->status);
        }

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori !== '') {
            $query->where('pengaduan.kategori_pengaduan_id', $request->kategori);
        }

        $pengaduan = $query->orderBy('pengaduan.created_at', 'desc')->get();

        return response()->json([
            'data' => $pengaduan->map(function ($item) use ($isAdmin) {
                return [
                    'id' => $item->id,
                    'kode_pengaduan' => $item->kode_pengaduan,
                    'nama_pelapor' => $item->submit_anonim ? 'Anonim' : $item->nama_pelapor,
                    'email_pelapor' => $isAdmin ? $item->email_pelapor : '***@***.***',
                    'kategori' => $item->nama_kategori ?? '-', // Langsung dari join
                    'status_pelapor' => ucfirst($item->status_pelapor),
                    'status_pengaduan' => $this->getStatusLabel($item->status_pengaduan),
                    'status_badge' => $this->getStatusBadge($item->status_pengaduan),
                    'tanggal_kejadian' => $item->tanggal_kejadian ? $item->tanggal_kejadian->format('d/m/Y') : '-',
                    'lokasi_kejadian' => $item->lokasi_kejadian ?? '-',
                    'terlapor_count' => $item->terlapor->count(),
                    'terlapor_names' => $item->terlapor->pluck('nama_terlapor')->join(', '),
                    'created_at' => $item->created_at->format('d/m/Y H:i'),
                    'can_cancel' => !$isAdmin && in_array($item->status_pengaduan, ['pending', 'butuh_bukti']),
                    'actions' => [
                        'show' => route('whistleblower.show', $item->id),
                        'cancel' => (!$isAdmin && in_array($item->status_pengaduan, ['pending', 'butuh_bukti'])) ? route('whistleblower.cancel', $item->id) : null,
                        'download' => $item->evidence_path ? route('whistleblower.download-bukti', $item->id) : null,
                    ]
                ];
            })
        ]);
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Menunggu',
            'proses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            'butuh_bukti' => 'Butuh Bukti Tambahan',
            'dibatalkan' => 'Dibatalkan',
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    private function getStatusBadge($status)
    {
        $badges = [
            'pending' => 'bg-warning',
            'proses' => 'bg-info',
            'selesai' => 'bg-success',
            'ditolak' => 'bg-danger',
            'butuh_bukti' => 'bg-secondary',
            'dibatalkan' => 'bg-dark',
        ];

        return $badges[$status] ?? 'bg-secondary';
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats()
    {
        $user = Auth::user();
        $isAdmin = $this->checkUserRole();

        $query = Pengaduan::query();

        if (!$isAdmin) {
            $query->where('email_pelapor', $user->email);
        }

        $stats = [
            'total' => $query->count(),
            'pending' => (clone $query)->where('status_pengaduan', 'pending')->count(),
            'proses' => (clone $query)->where('status_pengaduan', 'proses')->count(),
            'selesai' => (clone $query)->where('status_pengaduan', 'selesai')->count(),
            'ditolak' => (clone $query)->where('status_pengaduan', 'ditolak')->count(),
            'butuh_bukti' => (clone $query)->where('status_pengaduan', 'butuh_bukti')->count(),
            'dibatalkan' => (clone $query)->where('status_pengaduan', 'dibatalkan')->count(),
        ];

        if ($isAdmin) {
            // Additional admin stats
            $stats['anonim_submissions'] = Pengaduan::where('submit_anonim', true)->count();
            $stats['disabilitas'] = Pengaduan::where('memiliki_disabilitas', true)->count();
            $stats['recent_submissions'] = Pengaduan::where('created_at', '>=', now()->subDays(7))->count();
        }

        return response()->json($stats);
    }

    /**
     * Index method untuk menampilkan daftar pengaduan
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $this->checkUserRole();

        $query = Pengaduan::with(['terlapor'])
            ->leftJoin('ref_kategori_pengaduan', 'pengaduan.kategori_pengaduan_id', '=', 'ref_kategori_pengaduan.id')
            ->select('pengaduan.*', 'ref_kategori_pengaduan.nama_kategori');

        // Filter berdasarkan role
        if (!$isAdmin) {
            $query->where('pengaduan.email_pelapor', $user->email);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pengaduan.kode_pengaduan', 'ILIKE', "%{$search}%")
                  ->orWhere('pengaduan.nama_pelapor', 'ILIKE', "%{$search}%")
                  ->orWhere('pengaduan.judul_pengaduan', 'ILIKE', "%{$search}%")
                  ->orWhere('ref_kategori_pengaduan.nama_kategori', 'ILIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('pengaduan.status_pengaduan', $request->status);
        }

        // Filter by kategori
        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->where('pengaduan.kategori_pengaduan_id', $request->kategori);
        }

        $pengaduan = $query->orderBy('pengaduan.created_at', 'desc')->paginate(10);

        // Get categories for filter
        $kategori = DB::table('ref_kategori_pengaduan')
            ->select('id', 'nama_kategori')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        $stats = [
            'total' => $isAdmin ? Pengaduan::count() : Pengaduan::where('email_pelapor', $user->email)->count(),
            'pending' => $isAdmin ? Pengaduan::where('status_pengaduan', 'pending')->count() : Pengaduan::where('email_pelapor', $user->email)->where('status_pengaduan', 'pending')->count(),
            'proses' => $isAdmin ? Pengaduan::where('status_pengaduan', 'proses')->count() : Pengaduan::where('email_pelapor', $user->email)->where('status_pengaduan', 'proses')->count(),
            'selesai' => $isAdmin ? Pengaduan::where('status_pengaduan', 'selesai')->count() : Pengaduan::where('email_pelapor', $user->email)->where('status_pengaduan', 'selesai')->count(),
        ];

        if ($isAdmin) {
            return view('whistleblower.admin.index', compact('pengaduan', 'kategori', 'stats'));
        } else {
            return view('whistleblower.index', compact('pengaduan', 'kategori', 'stats'));
        }
    }
}