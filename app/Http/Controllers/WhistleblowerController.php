<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use App\Models\User;

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
    // public function adminDashboard()
    // {
    //     $selectedRole = session('selected_role');
        
    //     // Tentukan scope data berdasarkan role
    //     if ($selectedRole === 'Admin PPKPT Fakultas') {
    //         // Admin fakultas melihat SEMUA pengaduan di fakultasnya
    //         $query = Pengaduan::whereHas('user', function($q) {
    //             $q->whereHas('pegawai', function($pegawaiQuery) {
    //                 $pegawaiQuery->whereHas('unitKerja', function($unitQuery) {
    //                     // Dapatkan unit kerja admin yang sedang login
    //                     $adminPegawai = auth()->user()->pegawai;
                        
    //                     if ($adminPegawai && $adminPegawai->unitKerja) {
    //                         $adminUnitKerja = $adminPegawai->unitKerja;
                            
    //                         if ($adminUnitKerja->jenis_unit === 'Fakultas') {
    //                             // Jika admin di level fakultas, tampilkan semua pengaduan dari fakultas tersebut
    //                             $unitQuery->where('parent_unit', $adminUnitKerja->id)
    //                                      ->orWhere('id', $adminUnitKerja->id);
    //                         } else {
    //                             // Jika admin bukan di fakultas, tampilkan berdasarkan parent fakultasnya
    //                             $unitQuery->where('parent_unit', $adminUnitKerja->parent_unit)
    //                                      ->orWhere('id', $adminUnitKerja->parent_unit);
    //                         }
    //                     }
    //                 });
    //             });
    //         });
    //     } elseif ($selectedRole === 'Admin PPKPT Prodi') {
    //         // Admin prodi hanya melihat pengaduan dari prodi/unit kerjanya sendiri
    //         $query = Pengaduan::whereHas('user', function($q) {
    //             $q->whereHas('pegawai', function($pegawaiQuery) {
    //                 $pegawaiQuery->whereHas('unitKerja', function($unitQuery) {
    //                     // Dapatkan unit kerja admin yang sedang login
    //                     $adminPegawai = auth()->user()->pegawai;
                        
    //                     if ($adminPegawai && $adminPegawai->unitKerja) {
    //                         // Hanya tampilkan pengaduan dari unit kerja yang sama
    //                         $unitQuery->where('id', $adminPegawai->unitKerja->id);
    //                     }
    //                 });
    //             });
    //         });
    //     } else {
    //         // Fallback - tidak ada pengaduan yang bisa diakses
    //         $query = Pengaduan::where('id', 0);
    //     }

    //     // Statistik untuk admin
    //     $stats = [
    //         'total_pengaduan' => $query->count(),
    //         'pending' => (clone $query)->where('status_pengaduan', 'pending')->count(),
    //         'proses' => (clone $query)->where('status_pengaduan', 'proses')->count(),
    //         'selesai' => (clone $query)->where('status_pengaduan', 'selesai')->count(),
    //         'hari_ini' => (clone $query)->whereDate('created_at', today())->count(),
    //         'minggu_ini' => (clone $query)->whereBetween('created_at', [
    //             now()->startOfWeek(), 
    //             now()->endOfWeek()
    //         ])->count(),
    //     ];

    //     // Pengaduan terbaru untuk review
    //     $pengaduan_terbaru = (clone $query)
    //         ->with(['kategori', 'user'])
    //         ->latest('created_at')
    //         ->take(10)
    //         ->get();

    //     // Pengaduan prioritas (pending lama)
    //     $pengaduan_prioritas = (clone $query)
    //         ->with(['kategori', 'user'])
    //         ->where('status_pengaduan', 'pending')
    //         ->where('created_at', '<', now()->subDays(3))
    //         ->latest('created_at')
    //         ->take(5)
    //         ->get();

    //     return view('whistleblower.admin.dashboard', compact(
    //         'stats', 
    //         'pengaduan_terbaru', 
    //         'pengaduan_prioritas'
    //     ));
    // }

    
    /**
     * Dashboard untuk admin PPKPT - DEBUG VERSION
     */
    public function adminDashboard()
    {
        $selectedRole = session('selected_role');
        
        // DEBUG: Cek data admin yang login
        $adminUser = auth()->user();
        $adminPegawai = $adminUser->pegawai ?? null;
        $adminUnitKerja = $adminPegawai->unitKerja ?? null;
        
        // DEBUG: Log info admin
        logger('=== DEBUG ADMIN INFO ===');
        logger('Admin User ID: ' . $adminUser->id);
        logger('Admin Name: ' . $adminUser->name);
        logger('Admin Key Relation: ' . $adminUser->key_relation);
        logger('Selected Role: ' . $selectedRole);
        
        if ($adminPegawai) {
            logger('Admin Pegawai NIP: ' . $adminPegawai->nip);
            logger('Admin Pegawai Unit Kerja ID: ' . ($adminPegawai->unit_kerja_id ?? 'NULL'));
        } else {
            logger('Admin Pegawai: NULL');
        }
        
        if ($adminUnitKerja) {
            logger('Admin Unit Kerja ID: ' . $adminUnitKerja->id);
            logger('Admin Unit Kerja Nama: ' . $adminUnitKerja->nama_unit);
            logger('Admin Unit Kerja Jenis: ' . $adminUnitKerja->jenis_unit);
            logger('Admin Unit Kerja Parent: ' . ($adminUnitKerja->parent_unit ?? 'NULL'));
        } else {
            logger('Admin Unit Kerja: NULL');
        }
        
        // DEBUG: Cek total pengaduan yang ada
        $totalPengaduan = \App\Models\Pengaduan::count();
        logger('Total Pengaduan di Database: ' . $totalPengaduan);
        
        // DEBUG: Cek pengaduan dengan user yang punya pegawai
        $pengaduanWithPegawai = \App\Models\Pengaduan::whereHas('user', function($q) {
            $q->whereHas('pegawai');
        })->count();
        logger('Pengaduan dengan User yang punya Pegawai: ' . $pengaduanWithPegawai);
        
        // Untuk sementara, tampilkan SEMUA pengaduan untuk debug
        if ($selectedRole === 'Admin PPKPT Fakultas' || $selectedRole === 'Admin PPKPT Prodi') {
            logger('=== SHOWING ALL PENGADUAN FOR DEBUG ===');
            $query = \App\Models\Pengaduan::query();
        } else {
            // Fallback - tidak ada pengaduan yang bisa diakses
            $query = \App\Models\Pengaduan::where('id', 0);
        }
        
        // DEBUG: Log query count
        $queryCount = $query->count();
        logger('Query Result Count: ' . $queryCount);
        
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
        
        logger('Stats: ' . json_encode($stats));

        // Pengaduan terbaru untuk review
        $pengaduan_terbaru = (clone $query)
            ->with(['kategori', 'user'])
            ->latest('created_at')
            ->take(10)
            ->get();
            
        logger('Pengaduan Terbaru Count: ' . $pengaduan_terbaru->count());

        // Pengaduan prioritas (pending lama)
        $pengaduan_prioritas = (clone $query)
            ->with(['kategori', 'user'])
            ->where('status_pengaduan', 'pending')
            ->where('created_at', '<', now()->subDays(3))
            ->latest('created_at')
            ->take(5)
            ->get();
            
        logger('Pengaduan Prioritas Count: ' . $pengaduan_prioritas->count());

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

        // Query dasar untuk pengaduan user
        $query = Pengaduan::with('kategori')
            ->where('user_id', auth()->id());

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_pengaduan', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Search berdasarkan kode atau judul
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pengaduan', 'ILIKE', "%{$search}%")
                  ->orWhere('judul_pengaduan', 'ILIKE', "%{$search}%");
            });
        }

        // Daftar pengaduan dengan pagination
        $pengaduan = $query->latest('tanggal_pengaduan')->paginate(10);

        return view('whistleblower.index', compact('pengaduan'));
    }

    /**
     * Form buat pengaduan
     */
    public function create()
    {
        // Cek jika admin, redirect ke admin dashboard
        if ($redirect = $this->checkAdminRedirect()) {
            return $redirect;
        }

        $kategori = KategoriPengaduan::all();
        return view('whistleblower.create', compact('kategori'));
    }

    /**
     * Simpan pengaduan baru
     */
    public function store(Request $request)
    {
        // Cek jika admin, redirect ke admin dashboard dengan pesan
        if ($this->checkAdminRedirect()) {
            return redirect()->route('whistleblower.admin.dashboard')
                ->with('info', 'Admin PPKPT tidak dapat membuat pengaduan. Silakan gunakan dashboard admin untuk mengelola pengaduan.');
        }

        // Validasi dan simpan pengaduan
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi_pengaduan' => 'required|string',
            'is_anonim' => 'boolean',
        ]);

        $pengaduan = Pengaduan::create([
            'user_id' => auth()->id(),
            'kategori_id' => $request->kategori_id,
            'kode_pengaduan' => $this->generateKodePengaduan(),
            'judul_pengaduan' => $request->judul_pengaduan,
            'deskripsi_pengaduan' => $request->deskripsi_pengaduan,
            'tanggal_pengaduan' => now(),
            'status_pengaduan' => 'pending',
            'is_anonim' => $request->has('is_anonim'),
        ]);

        return redirect()->route('whistleblower.show', $pengaduan->id)
            ->with('success', 'Pengaduan berhasil dibuat dengan kode: ' . $pengaduan->kode_pengaduan);
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

        $pengaduan = Pengaduan::with(['kategori', 'user'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('whistleblower.show', compact('pengaduan'));
    }

    /**
     * Hapus pengaduan
     */
    public function destroy($id)
    {
        // Cek jika admin, redirect ke admin dashboard
        if ($redirect = $this->checkAdminRedirect()) {
            return $redirect;
        }

        $pengaduan = Pengaduan::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status_pengaduan', 'pending') // Hanya pending yang bisa dihapus
            ->firstOrFail();

        $pengaduan->delete();

        return redirect()->route('whistleblower.index')
            ->with('success', 'Pengaduan berhasil dibatalkan');
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

        public function debugData()
    {
        $adminUser = auth()->user();
        
        $data = [
            'admin_user' => [
                'id' => $adminUser->id,
                'name' => $adminUser->name,
                'email' => $adminUser->email,
                'key_relation' => $adminUser->key_relation,
            ],
            'admin_pegawai' => $adminUser->pegawai ? [
                'nip' => $adminUser->pegawai->nip,
                'nama' => $adminUser->pegawai->nama,
                'unit_kerja_id' => $adminUser->pegawai->unit_kerja_id,
            ] : null,
            'admin_unit_kerja' => $adminUser->pegawai && $adminUser->pegawai->unitKerja ? [
                'id' => $adminUser->pegawai->unitKerja->id,
                'nama_unit' => $adminUser->pegawai->unitKerja->nama_unit,
                'jenis_unit' => $adminUser->pegawai->unitKerja->jenis_unit,
                'parent_unit' => $adminUser->pegawai->unitKerja->parent_unit,
            ] : null,
            'selected_role' => session('selected_role'),
            'total_pengaduan' => \App\Models\Pengaduan::count(),
            'pengaduan_dengan_user' => \App\Models\Pengaduan::whereHas('user')->count(),
            'pengaduan_dengan_pegawai' => \App\Models\Pengaduan::whereHas('user.pegawai')->count(),
            'sample_pengaduan' => \App\Models\Pengaduan::with(['user.pegawai.unitKerja'])->first(),
        ];
        
        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
}