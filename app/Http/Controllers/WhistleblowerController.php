<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pengaduan;
use App\Models\PengaduanTerlapor;

class WhistleblowerController extends Controller
{
    /**
     * Check if user is admin PPKPT and redirect accordingly
     */
    private function checkUserRole()
    {
        $selectedRole = session('selected_role');
        return in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi']);
    }

    /**
     * Dashboard method that was missing (route calls this)
     */
    public function dashboard()
    {
        // Check user role and redirect to appropriate dashboard
        if ($this->checkUserRole()) {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard();
        }
    }

    /**
     * User Dashboard - untuk pelapor biasa
     * FIXED: Menggunakan table whistle_pengaduan dengan joins
     */
    public function userDashboard()
    {
        $user = Auth::user();

        // Using DB facade with proper joins
        $pengaduan = DB::table('whistle_pengaduan')
            ->leftJoin('ref_kategori_pengaduan', 'whistle_pengaduan.kategori_pengaduan_id', '=', 'ref_kategori_pengaduan.id')
            ->leftJoin('pengaduan_terlapor', 'whistle_pengaduan.id', '=', 'pengaduan_terlapor.pengaduan_id')
            ->where('whistle_pengaduan.email_pelapor', $user->email)
            ->select(
                'whistle_pengaduan.*',
                'ref_kategori_pengaduan.nama_kategori',
                'pengaduan_terlapor.nama_terlapor'
            )
            ->orderBy('whistle_pengaduan.created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_pengaduan' => DB::table('whistle_pengaduan')->where('email_pelapor', $user->email)->count(),
            'pending' => DB::table('whistle_pengaduan')->where('email_pelapor', $user->email)->where('status_pengaduan', 'pending')->count(),
            'proses' => DB::table('whistle_pengaduan')->where('email_pelapor', $user->email)->where('status_pengaduan', 'proses')->count(),
            'selesai' => DB::table('whistle_pengaduan')->where('email_pelapor', $user->email)->where('status_pengaduan', 'selesai')->count(),
        ];

        return view('whistleblower.user.dashboard', compact('pengaduan', 'stats'));
    }

    /**
     * Admin Dashboard - untuk admin PPKPT
     * FIXED: Menggunakan table whistle_pengaduan dengan joins
     */
    private function adminDashboard()
    {
        $pengaduan = DB::table('whistle_pengaduan')
            ->leftJoin('ref_kategori_pengaduan', 'whistle_pengaduan.kategori_pengaduan_id', '=', 'ref_kategori_pengaduan.id')
            ->leftJoin('pengaduan_terlapor', 'whistle_pengaduan.id', '=', 'pengaduan_terlapor.pengaduan_id')
            ->select(
                'whistle_pengaduan.*',
                'ref_kategori_pengaduan.nama_kategori',
                'pengaduan_terlapor.nama_terlapor'
            )
            ->orderBy('whistle_pengaduan.created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_pengaduan' => DB::table('whistle_pengaduan')->count(),
            'pending' => DB::table('whistle_pengaduan')->where('status_pengaduan', 'pending')->count(),
            'proses' => DB::table('whistle_pengaduan')->where('status_pengaduan', 'proses')->count(),
            'selesai' => DB::table('whistle_pengaduan')->where('status_pengaduan', 'selesai')->count(),
            'ditolak' => DB::table('whistle_pengaduan')->where('status_pengaduan', 'ditolak')->count(),
            'butuh_bukti' => DB::table('whistle_pengaduan')->where('status_pengaduan', 'butuh_bukti')->count(),
        ];

        return view('whistleblower.admin.dashboard', compact('pengaduan', 'stats'));
    }

    /**
     * Show form to create new pengaduan
     */
    public function create()
    {
        // Cek jika admin, tampilkan pesan error
        $selectedRole = session('selected_role');
        if (in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'])) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Admin tidak dapat membuat pengaduan.');
        }

        // Get kategori from database (tanpa filter is_active karena kolom tidak ada)
        $kategori = DB::table('ref_kategori_pengaduan')
            ->orderBy('nama_kategori')
            ->get();

        if ($kategori->isEmpty()) {
            Log::warning('No active kategori found for whistleblower form');
        } else {
            Log::info('Found ' . $kategori->count() . ' active categories');
        }
        
        $user = Auth::user();
        
        return view('whistleblower.user.create', compact('kategori', 'user'));
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

            // Create pengaduan using DB insert to whistle_pengaduan table
            $pengaduan_id = DB::table('whistle_pengaduan')->insertGetId([
                'id' => \Illuminate\Support\Str::uuid(),
                'kode_pengaduan' => $kode_pengaduan,
                'judul_pengaduan' => 'Pengaduan - ' . substr($validated['cerita_singkat_peristiwa'], 0, 50) . '...',
                'uraian_pengaduan' => $validated['deskripsi_pengaduan'] ?? $validated['cerita_singkat_peristiwa'],
                'anonymous' => $submit_anonim,
                'status_pengaduan' => 'pending',
                'kategori_pengaduan_id' => $validated['kategori_pengaduan_id'],
                'tanggal_pengaduan' => now(),
                'pelapor_id' => $user->id,
                'nama_pelapor' => $nama_pelapor,
                'email_pelapor' => $user->email,
                'status_pelapor' => $validated['status_pelapor'],
                'cerita_singkat_peristiwa' => $validated['cerita_singkat_peristiwa'],
                'tanggal_kejadian' => $validated['tanggal_kejadian'],
                'lokasi_kejadian' => $validated['lokasi_kejadian'],
                'memiliki_disabilitas' => $request->boolean('memiliki_disabilitas'),
                'jenis_disabilitas' => $validated['jenis_disabilitas'],
                'alasan_pengaduan' => json_encode($validated['alasan_pengaduan']),
                'evidence_type' => $validated['evidence_type'],
                'evidence_gdrive_link' => $validated['evidence_gdrive_link'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create terlapor data
            foreach ($validated['terlapor'] as $terlapor_data) {
                DB::table('pengaduan_terlapor')->insert([
                    'pengaduan_id' => $pengaduan_id,
                    'nama_terlapor' => $terlapor_data['nama_terlapor'] ?? 'Tidak disebutkan',
                    'status_terlapor' => $terlapor_data['status_terlapor'],
                    'nomor_identitas' => $terlapor_data['nomor_identitas'],
                    'unit_kerja_fakultas' => $terlapor_data['unit_kerja_fakultas'],
                    'kontak_terlapor' => $terlapor_data['kontak_terlapor'],
                    'created_at' => now(),
                    'updated_at' => now(),
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
     * FIXED: Menggunakan table whistle_pengaduan dengan joins
     */
    public function show($id)
    {
        $pengaduan = DB::table('whistle_pengaduan')
            ->leftJoin('ref_kategori_pengaduan', 'whistle_pengaduan.kategori_pengaduan_id', '=', 'ref_kategori_pengaduan.id')
            ->select('whistle_pengaduan.*', 'ref_kategori_pengaduan.nama_kategori')
            ->where('whistle_pengaduan.id', $id)
            ->first();

        if (!$pengaduan) {
            abort(404, 'Pengaduan tidak ditemukan.');
        }
        
        // Get terlapor data
        $terlapor = DB::table('pengaduan_terlapor')
            ->where('pengaduan_id', $id)
            ->get();
        
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

        return view('whistleblower.user.show', compact('pengaduan', 'terlapor', 'alasan_pengaduan', 'isAdmin'));
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

        DB::table('whistle_pengaduan')
            ->where('id', $id)
            ->update([
                'status_pengaduan' => $validated['status_pengaduan'],
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
        $pengaduan = DB::table('whistle_pengaduan')
            ->where('id', $id)
            ->where('email_pelapor', $user->email)
            ->first();

        if (!$pengaduan) {
            abort(404, 'Pengaduan tidak ditemukan.');
        }

        // Check if pengaduan can be cancelled
        if (!in_array($pengaduan->status_pengaduan, ['pending', 'butuh_bukti'])) {
            return redirect()->back()
                ->with('error', 'Pengaduan tidak dapat dibatalkan pada status ini.');
        }

        DB::table('whistle_pengaduan')
            ->where('id', $id)
            ->update([
                'status_pengaduan' => 'dibatalkan',
                'updated_at' => now(),
            ]);

        return redirect()->route('whistleblower.dashboard')
            ->with('success', 'Pengaduan berhasil dibatalkan.');
    }
}