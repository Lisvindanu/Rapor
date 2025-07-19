<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\PengaduanTerlapor;
use App\Models\KategoriPengaduan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class WhistleblowerController extends Controller
{
    /**
     * Check if user is admin PPKPT and redirect accordingly
     */
    private function checkAdminRedirect()
    {
        $selectedRole = session('selected_role');
        if (in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'])) {
            return redirect()->route('whistleblower.admin.dashboard');
        }
        return null;
    }

    /**
     * Dashboard utama - route ke dashboard yang sesuai
     */
    public function dashboard()
    {
        $selectedRole = session('selected_role');
        if (in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'])) {
            return $this->adminDashboard();
        }
        return $this->userDashboard();
    }

    /**
     * Dashboard untuk user biasa
     */
    public function userDashboard()
    {
        // Cek jika admin, redirect ke admin dashboard
        if ($redirect = $this->checkAdminRedirect()) {
            return $redirect;
        }

        // Statistik pengaduan untuk user yang login
        $stats = [
            'total_pengaduan' => Pengaduan::where('user_id', auth()->id())->count(),
            'pending' => Pengaduan::where('user_id', auth()->id())
                                 ->where('status_pengaduan', 'pending')->count(),
            'proses' => Pengaduan::where('user_id', auth()->id())
                                ->where('status_pengaduan', 'proses')->count(),
            'selesai' => Pengaduan::where('user_id', auth()->id())
                                 ->where('status_pengaduan', 'selesai')->count(),
        ];

        // Riwayat pengaduan terbaru (5 terakhir)
        $riwayat_pengaduan = Pengaduan::with('kategori')
            ->where('user_id', auth()->id())
            ->latest('tanggal_pengaduan')
            ->take(5)
            ->get();

        return view('whistleblower.dashboard', compact('stats', 'riwayat_pengaduan'));
    }

    /**
     * Dashboard untuk admin PPKPT
     */
    public function adminDashboard()
    {
        $selectedRole = session('selected_role');
        
        $adminUser = auth()->user();
        $adminPegawai = $adminUser->pegawai ?? null;
        $adminUnitKerja = $adminPegawai->unitKerja ?? null;
        
        // Untuk sementara, tampilkan SEMUA pengaduan untuk admin PPKPT
        if ($selectedRole === 'Admin PPKPT Fakultas' || $selectedRole === 'Admin PPKPT Prodi') {
            $query = \App\Models\Pengaduan::query();
        } else {
            // Fallback - tidak ada pengaduan yang bisa diakses
            $query = \App\Models\Pengaduan::where('id', 0);
        }
        
        // Statistik untuk admin
        $stats = [
            'total_pengaduan' => $query->count(),
            'pending' => (clone $query)->where('status_pengaduan', 'pending')->count(),
            'proses' => (clone $query)->where('status_pengaduan', 'proses')->count(),
            'selesai' => (clone $query)->where('status_pengaduan', 'selesai')->count(),
            'hari_ini' => (clone $query)->whereDate('created_at', today())->count(),
            'minggu_ini' => (clone $query)->whereBetween('created_at', [
                now()->startOfWeek(), 
                now()->endOfWeek()
            ])->count(),
        ];

        // Pengaduan terbaru untuk review
        $pengaduan_terbaru = (clone $query)
            ->with(['kategori', 'user'])
            ->latest('created_at')
            ->take(10)
            ->get();

        // Pengaduan prioritas (pending lama)
        $pengaduan_prioritas = (clone $query)
            ->with(['kategori', 'user'])
            ->where('status_pengaduan', 'pending')
            ->where('created_at', '<', now()->subDays(3))
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('whistleblower.admin.dashboard', compact(
            'stats', 
            'pengaduan_terbaru', 
            'pengaduan_prioritas'
        ));
    }

    /**
     * Daftar pengaduan untuk user
     */
    public function index(Request $request)
    {
        // Cek jika admin, redirect ke admin dashboard
        if ($redirect = $this->checkAdminRedirect()) {
            return $redirect;
        }

        $query = Pengaduan::with('kategori')
            ->where('user_id', auth()->id());

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status !== '') {
            $query->where('status_pengaduan', $request->status);
        }

        // Search berdasarkan judul atau kode
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_pengaduan', 'like', "%{$search}%")
                  ->orWhere('kode_pengaduan', 'like', "%{$search}%");
            });
        }

        $pengaduan = $query->latest('tanggal_pengaduan')->paginate(10);

        return view('whistleblower.index', compact('pengaduan'));
    }

    /**
     * Tampilkan form create pengaduan
     */
    public function create()
    {
        // Cek jika admin, redirect ke admin dashboard
        if ($redirect = $this->checkAdminRedirect()) {
            return $redirect;
        }

        $kategori = KategoriPengaduan::active()->get();
        return view('whistleblower.create', compact('kategori'));
    }

    /**
     * Store pengaduan baru dengan informasi terlapor
     */
    public function store(Request $request)
    {
        // Cek jika admin, tampilkan pesan error
        $selectedRole = session('selected_role');
        if (in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'])) {
            return redirect()->route('whistleblower.admin.dashboard')
                ->with('error', 'Admin tidak dapat membuat pengaduan. 
                Silakan gunakan dashboard admin untuk mengelola pengaduan.');
        }

        // Validasi input
        $request->validate([
            'status_pelapor' => 'required|in:saksi,korban',
            'memiliki_disabilitas' => 'required|boolean',
            'jenis_disabilitas' => 'nullable|string|max:500',
            'judul_pengaduan' => 'required|string|max:255',
            'cerita_singkat_peristiwa' => 'required|string',
            'tanggal_kejadian' => 'nullable|date|before_or_equal:today',
            'lokasi_kejadian' => 'nullable|string|max:255',
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'alasan_pengaduan' => 'required|array|min:1',
            'alasan_pengaduan.*' => 'string',
            'evidence_type' => 'required|in:file,gdrive',
            'evidence_file' => 'required_if:evidence_type,file|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'evidence_gdrive_link' => 'required_if:evidence_type,gdrive|url',
            'is_anonim' => 'nullable|boolean',
            'agreement' => 'required|accepted',
            'terlapor' => 'required|array|min:1',
            'terlapor.*.nama' => 'required|string|max:255',
            'terlapor.*.status' => 'required|in:mahasiswa,pegawai',
            'terlapor.*.nomor_identitas' => 'nullable|string|max:50',
            'terlapor.*.unit_kerja' => 'nullable|string|max:255',
            'terlapor.*.kontak' => 'required|string|max:255'
        ], [
            'terlapor.required' => 'Minimal harus ada satu terlapor',
            'terlapor.*.nama.required' => 'Nama terlapor harus diisi',
            'terlapor.*.status.required' => 'Status terlapor harus dipilih',
            'terlapor.*.kontak.required' => 'Kontak terlapor harus diisi',
            'evidence_file.required_if' => 'File bukti harus dilampirkan',
            'evidence_gdrive_link.required_if' => 'Link Google Drive harus diisi',
            'alasan_pengaduan.required' => 'Minimal pilih satu alasan pengaduan',
            'agreement.accepted' => 'Anda harus menyetujui kebijakan privasi'
        ]);

        DB::beginTransaction();
        
        try {
            // Handle file upload
            $evidencePath = null;
            $evidenceGdriveLink = null;
            
            if ($request->evidence_type === 'file' && $request->hasFile('evidence_file')) {
                $evidencePath = $request->file('evidence_file')->store('evidence', 'public');
            } elseif ($request->evidence_type === 'gdrive') {
                $evidenceGdriveLink = $request->evidence_gdrive_link;
            }

            // Create pengaduan
            $pengaduan = Pengaduan::create([
                'user_id' => Auth::id(),
                'kategori_id' => $request->kategori_id,
                'kode_pengaduan' => $this->generateKodePengaduan(),
                'judul_pengaduan' => $request->judul_pengaduan,
                'deskripsi_pengaduan' => $request->cerita_singkat_peristiwa, // untuk backward compatibility
                'status_pelapor' => $request->status_pelapor,
                'cerita_singkat_peristiwa' => $request->cerita_singkat_peristiwa,
                'tanggal_kejadian' => $request->tanggal_kejadian,
                'lokasi_kejadian' => $request->lokasi_kejadian,
                'memiliki_disabilitas' => $request->memiliki_disabilitas,
                'jenis_disabilitas' => $request->jenis_disabilitas,
                'alasan_pengaduan' => $request->alasan_pengaduan,
                'tanggal_pengaduan' => now(),
                'status_pengaduan' => 'pending',
                'is_anonim' => $request->boolean('is_anonim'),
                'evidence_path' => $evidencePath,
                'evidence_type' => $request->evidence_type,
                'evidence_gdrive_link' => $evidenceGdriveLink
            ]);

            // Create terlapor records
            foreach ($request->terlapor as $terlaporData) {
                PengaduanTerlapor::create([
                    'pengaduan_id' => $pengaduan->id,
                    'nama_terlapor' => $terlaporData['nama'],
                    'status_terlapor' => $terlaporData['status'],
                    'nomor_identitas' => $terlaporData['nomor_identitas'] ?? null,
                    'unit_kerja_fakultas' => $terlaporData['unit_kerja'] ?? null,
                    'kontak_terlapor' => $terlaporData['kontak']
                ]);
            }

            DB::commit();

            return redirect()->route('whistleblower.show', $pengaduan->id)
                ->with('success', 'Pengaduan berhasil dikirim dengan kode: ' . $pengaduan->kode_pengaduan);

        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete uploaded file if exists
            if ($evidencePath && Storage::disk('public')->exists($evidencePath)) {
                Storage::disk('public')->delete($evidencePath);
            }
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengaduan: ' . $e->getMessage());
        }
    }

    /**
     * Detail pengaduan
     */
    public function show($id)
    {
        // Cek jika admin, redirect ke admin dashboard
        if ($redirect = $this->checkAdminRedirect()) {
            return $redirect;
        }

        $pengaduan = Pengaduan::with(['kategori', 'user', 'terlapor'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('whistleblower.show', compact('pengaduan'));
    }

    /**
     * Batalkan pengaduan (hanya untuk status tertentu)
     */
    public function cancel($id)
    {
        $pengaduan = Pengaduan::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$pengaduan->canBeCancelled()) {
            return back()->with('error', 'Pengaduan tidak dapat dibatalkan karena sudah dalam proses atau selesai');
        }

        // Update status menjadi dibatalkan
        $pengaduan->update([
            'status_pengaduan' => 'dibatalkan',
            'admin_response' => 'Pengaduan dibatalkan oleh pelapor pada ' . now()->format('d/m/Y H:i:s')
        ]);

        return redirect()->route('whistleblower.index')
            ->with('success', 'Pengaduan berhasil dibatalkan');
    }

    /**
     * Halaman sukses setelah submit
     */
    public function success($kodePengaduan)
    {
        $pengaduan = Pengaduan::where('kode_pengaduan', $kodePengaduan)->firstOrFail();
        return view('whistleblower.success', compact('pengaduan'));
    }

    /**
     * Halaman cek status untuk pengaduan anonim
     */
    public function statusPage()
    {
        return view('whistleblower.status-page');
    }

    /**
     * Cek status pengaduan berdasarkan kode
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'kode_pengaduan' => 'required|string'
        ]);

        $pengaduan = Pengaduan::where('kode_pengaduan', $request->kode_pengaduan)->first();

        if (!$pengaduan) {
            return back()->with('error', 'Kode pengaduan tidak ditemukan');
        }

        return view('whistleblower.status-result', compact('pengaduan'));
    }

    /**
     * Hapus pengaduan (legacy - sekarang menggunakan cancel)
     */
    public function destroy($id)
    {
        return $this->cancel($id);
    }

    /**
     * Generate kode pengaduan otomatis
     */
    private function generateKodePengaduan()
    {
        $prefix = 'WB';
        $year = date('Y');
        $month = date('m');
        
        // Hitung jumlah pengaduan bulan ini
        $count = Pengaduan::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;

        return $prefix . $year . $month . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Update status pengaduan (untuk admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengaduan' => 'required|in:pending,proses,selesai,ditolak,butuh_bukti',
            'admin_response' => 'nullable|string'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        
        $pengaduan->update([
            'status_pengaduan' => $request->status_pengaduan,
            'admin_response' => $request->admin_response,
            'handled_by' => auth()->id(),
            'closed_at' => in_array($request->status_pengaduan, ['selesai', 'ditolak']) ? now() : null
        ]);

        return back()->with('success', 'Status pengaduan berhasil diupdate');
    }

    /**
     * Detail pengaduan untuk admin dengan informasi terlapor
     */
    public function adminShow($id)
    {
        $pengaduan = Pengaduan::with(['kategori', 'user', 'terlapor', 'handler'])
            ->findOrFail($id);

        return view('whistleblower.admin.show', compact('pengaduan'));
    }

    /**
     * Method legacy untuk kompatibilitas (jika ada yang masih menggunakan)
     */
    public function riwayat()
    {
        return $this->index(request());
    }

    public function detail($id)
    {
        return $this->show($id);
    }

    public function update(Request $request)
    {
        // Method ini bisa digunakan untuk update pengaduan jika diperlukan
        // Sementara redirect ke index
        return redirect()->route('whistleblower.index');
    }
}