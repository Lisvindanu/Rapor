<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use App\Models\User;

class WhistleblowerAdminController extends Controller
{
    /**
     * Check if user has admin PPKPT role
     */
    private function checkAdminRole()
    {
        $selectedRole = session('selected_role');
        
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (!$selectedRole) {
            return redirect()->route('gate')->with('error', 'Silakan pilih role terlebih dahulu');
        }
        
        $allowedRoles = ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'];
        
        if (!in_array($selectedRole, $allowedRoles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman admin PPKPT.');
        }
        
        return null;
    }

    /**
     * Get query pengaduan berdasarkan role admin
     */
    private function getPengaduanQuery()
    {
        // Check admin role first
        if ($redirect = $this->checkAdminRole()) {
            return $redirect;
        }
        
        $selectedRole = session('selected_role');
        
        if ($selectedRole === 'Admin PPKPT Fakultas') {
            // Admin fakultas melihat SEMUA pengaduan di fakultasnya
            return Pengaduan::whereHas('user', function($q) {
                $q->whereHas('pegawai', function($pegawaiQuery) {
                    $pegawaiQuery->whereHas('unitKerja', function($unitQuery) {
                        // Dapatkan unit kerja admin yang sedang login
                        $adminPegawai = auth()->user()->pegawai;
                        
                        if ($adminPegawai && $adminPegawai->unitKerja) {
                            $adminUnitKerja = $adminPegawai->unitKerja;
                            
                            if ($adminUnitKerja->jenis_unit === 'Fakultas') {
                                // Jika admin di level fakultas, tampilkan semua pengaduan dari fakultas tersebut
                                $unitQuery->where('parent_unit', $adminUnitKerja->id)
                                         ->orWhere('id', $adminUnitKerja->id);
                            } else {
                                // Jika admin bukan di fakultas, tampilkan berdasarkan parent fakultasnya
                                $unitQuery->where('parent_unit', $adminUnitKerja->parent_unit)
                                         ->orWhere('id', $adminUnitKerja->parent_unit);
                            }
                        }
                    });
                });
            });
        } elseif ($selectedRole === 'Admin PPKPT Prodi') {
            // Admin prodi hanya melihat pengaduan dari prodi/unit kerjanya sendiri
            return Pengaduan::whereHas('user', function($q) {
                $q->whereHas('pegawai', function($pegawaiQuery) {
                    $pegawaiQuery->whereHas('unitKerja', function($unitQuery) {
                        // Dapatkan unit kerja admin yang sedang login
                        $adminPegawai = auth()->user()->pegawai;
                        
                        if ($adminPegawai && $adminPegawai->unitKerja) {
                            // Hanya tampilkan pengaduan dari unit kerja yang sama
                            $unitQuery->where('id', $adminPegawai->unitKerja->id);
                        }
                    });
                });
            });
        }
        
        // Fallback - tidak ada pengaduan yang bisa diakses
        return Pengaduan::where('id', 0);
    }
    
    /**
     * Daftar pengaduan untuk admin
     */
    public function index(Request $request)
    {
        $query = $this->getPengaduanQuery();
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_pengaduan', $request->status);
        }
        
        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
        
        // Filter prioritas (pending > 3 hari)
        if ($request->get('filter') === 'prioritas') {
            $query->where('status_pengaduan', 'pending')
                  ->where('created_at', '<', now()->subDays(3));
        }
        
        // Search berdasarkan kode, judul, atau nama pelapor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pengaduan', 'ILIKE', "%{$search}%")
                  ->orWhere('judul_pengaduan', 'ILIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'ILIKE', "%{$search}%");
                  });
            });
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if ($sortBy === 'priority') {
            // Custom sorting untuk prioritas
            $query->orderByRaw("
                CASE 
                    WHEN status_pengaduan = 'pending' AND created_at < ? THEN 1
                    WHEN status_pengaduan = 'pending' THEN 2
                    WHEN status_pengaduan = 'proses' THEN 3
                    ELSE 4
                END ASC, created_at DESC
            ", [now()->subDays(3)]);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $pengaduan = $query->with(['kategori', 'user', 'handler'])->paginate(15);
        
        // Data untuk filter
        $kategori = KategoriPengaduan::active()->get();
        $statusCounts = $this->getStatusCounts();
        
        return view('whistleblower.admin.pengaduan.index', compact(
            'pengaduan', 
            'kategori', 
            'statusCounts'
        ));
    }
    
    /**
     * Detail pengaduan untuk admin
     */
    public function show($id)
    {
        $pengaduan = $this->getPengaduanQuery()
            ->with(['kategori', 'user', 'handler'])
            ->findOrFail($id);
            
        return view('whistleblower.admin.pengaduan.show', compact('pengaduan'));
    }
    
    /**
     * Update status pengaduan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengaduan' => 'required|in:pending,proses,selesai,ditolak',
            'admin_response' => 'required_if:status_pengaduan,selesai,ditolak|nullable|string',
        ]);
        
        $pengaduan = $this->getPengaduanQuery()->findOrFail($id);
        
        $pengaduan->update([
            'status_pengaduan' => $request->status_pengaduan,
            'admin_response' => $request->admin_response,
            'handled_by' => auth()->id(),
            'closed_at' => in_array($request->status_pengaduan, ['selesai', 'ditolak']) ? now() : null,
        ]);
        
        // Log aktivitas (opsional)
        // ActivityLog::create([...]);
        
        return redirect()->back()->with('success', 'Status pengaduan berhasil diupdate');
    }
    
    /**
     * Assign pengaduan ke admin lain
     */
    public function assignTo(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'notes' => 'nullable|string'
        ]);
        
        $pengaduan = $this->getPengaduanQuery()->findOrFail($id);
        
        $pengaduan->update([
            'handled_by' => $request->assigned_to,
            'admin_response' => $pengaduan->admin_response . "\n\n[" . now()->format('d/m/Y H:i') . "] Ditugaskan kepada " . User::find($request->assigned_to)->name . ($request->notes ? ": " . $request->notes : "")
        ]);
        
        return redirect()->back()->with('success', 'Pengaduan berhasil ditugaskan');
    }
    
    /**
     * Export pengaduan ke Excel/PDF
     */
    public function export(Request $request)
    {
        $query = $this->getPengaduanQuery();
        
        // Apply filters sama seperti di index
        if ($request->filled('status')) {
            $query->where('status_pengaduan', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $pengaduan = $query->with(['kategori', 'user'])->get();
        
        // Return Excel atau PDF sesuai request
        if ($request->format === 'pdf') {
            return $this->exportToPdf($pengaduan);
        } else {
            return $this->exportToExcel($pengaduan);
        }
    }
    
    /**
     * Get counts untuk setiap status
     */
    private function getStatusCounts()
    {
        $query = $this->getPengaduanQuery();
        
        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status_pengaduan', 'pending')->count(),
            'proses' => (clone $query)->where('status_pengaduan', 'proses')->count(),
            'selesai' => (clone $query)->where('status_pengaduan', 'selesai')->count(),
            'ditolak' => (clone $query)->where('status_pengaduan', 'ditolak')->count(),
            'prioritas' => (clone $query)->where('status_pengaduan', 'pending')
                                        ->where('created_at', '<', now()->subDays(3))
                                        ->count(),
        ];
    }
    
    /**
     * Bulk actions untuk pengaduan
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_as_read,change_status,assign_to',
            'pengaduan_ids' => 'required|array',
            'pengaduan_ids.*' => 'exists:pengaduan,id',
            'status' => 'required_if:action,change_status|in:pending,proses,selesai,ditolak',
            'assigned_to' => 'required_if:action,assign_to|exists:users,id'
        ]);
        
        $query = $this->getPengaduanQuery()->whereIn('id', $request->pengaduan_ids);
        
        switch ($request->action) {
            case 'change_status':
                $query->update([
                    'status_pengaduan' => $request->status,
                    'handled_by' => auth()->id()
                ]);
                break;
                
            case 'assign_to':
                $query->update([
                    'handled_by' => $request->assigned_to
                ]);
                break;
        }
        
        return redirect()->back()->with('success', 'Bulk action berhasil dijalankan');
    }
}