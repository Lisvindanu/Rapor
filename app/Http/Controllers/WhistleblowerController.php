<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use App\Models\RefKategoriPengaduan; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WhistleblowerController extends Controller
{
    /**
     * Mengarahkan ke dashboard yang sesuai berdasarkan role
     * FIX: Menambahkan method dashboard() yang hilang
     */
    public function dashboard()
    {
        $selectedRole = session('selected_role');
        
        if (in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi'])) {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard();
        }
    }

    /**
     * Dashboard untuk user biasa (pelapor)
     */
    public function userDashboard()
    {
        $user = Auth::user();
        
        // Ambil pengaduan milik user ini
        $pengaduan = Pengaduan::where('email_pelapor', $user->email)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
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
     * Dashboard untuk admin PPKPT
     */
    public function adminDashboard()
    {
        $pengaduan = Pengaduan::with('kategori')
            ->orderBy('created_at', 'desc')
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
     * Check if user is admin PPKPT
     */
    private function checkUserRole()
    {
        $selectedRole = session('selected_role');
        return in_array($selectedRole, ['Admin PPKPT Fakultas', 'Admin PPKPT Prodi']);
    }

    /**
     * Form create pengaduan
     */
    public function create()
    {
        // Cek jika admin, tampilkan pesan error
        if ($this->checkUserRole()) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Admin tidak dapat membuat pengaduan.');
        }

        // Gunakan model RefKategoriPengaduan
        $kategori_pengaduan = RefKategoriPengaduan::all();
        
        $user = Auth::user();

        return view('whistleblower.user.create', compact('kategori_pengaduan', 'user'));
    }

    /**
     * Store pengaduan baru dengan data terlapor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'status_pelapor' => 'required|in:saksi,korban',
            'memiliki_disabilitas' => 'boolean',
            'jenis_disabilitas' => 'nullable|string|max:255',
            'kategori_pengaduan_id' => 'required|exists:ref_kategori_pengaduan,id',
            'tanggal_kejadian' => 'required|date',
            'lokasi_kejadian' => 'required|string|max:255',
            'cerita_singkat_peristiwa' => 'required|string',
            'alasan_pengaduan' => 'required|array|min:1',
            'alasan_pengaduan.*' => 'string',
            'terlapor' => 'required|array|min:1',
            'terlapor.*.nama_terlapor' => 'required|string|max:255',
            'terlapor.*.status_terlapor' => 'required|in:mahasiswa,pegawai',
            'terlapor.*.nomor_identitas' => 'nullable|string|max:255',
            'terlapor.*.unit_kerja_fakultas' => 'nullable|string|max:255',
            'terlapor.*.kontak_terlapor' => 'required|string|max:255',
            'file_bukti' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'evidence_gdrive_link' => 'nullable|url',
            'persetujuan_kebijakan' => 'required|accepted',
        ]);

        $user = Auth::user();
        
        // Handle file upload
        $file_path = null;
        if ($request->hasFile('file_bukti')) {
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
            'judul_pengaduan' => 'Pengaduan - ' . substr($validated['cerita_singkat_peristiwa'], 0, 50) . '...',
            'uraian_pengaduan' => $validated['cerita_singkat_peristiwa'],
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
            'alasan_pengaduan' => $validated['alasan_pengaduan'],
            'evidence_type' => 'file',
            'evidence_gdrive_link' => $validated['evidence_gdrive_link'],
        ]);

        // Create terlapor data
        foreach ($validated['terlapor'] as $terlapor_data) {
            $pengaduan->terlapor()->create([
                'nama_terlapor' => $terlapor_data['nama_terlapor'],
                'status_terlapor' => $terlapor_data['status_terlapor'],
                'nomor_identitas' => $terlapor_data['nomor_identitas'],
                'unit_kerja_fakultas' => $terlapor_data['unit_kerja_fakultas'],
                'kontak_terlapor' => $terlapor_data['kontak_terlapor'],
            ]);
        }

        return redirect()->route('whistleblower.success', $kode_pengaduan)
            ->with('success', 'Pengaduan berhasil dikirim dengan kode: ' . $kode_pengaduan);
    }

    /**
     * Halaman sukses setelah submit
     */
    public function success($kodePengaduan)
    {
        $pengaduan = Pengaduan::where('kode_pengaduan', $kodePengaduan)->first();
        
        if (!$pengaduan) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Pengaduan tidak ditemukan.');
        }

        return view('whistleblower.user.success', compact('pengaduan'));
    }

    /**
     * Batalkan pengaduan
     */
    public function cancel($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Cek ownership
        if ($pengaduan->email_pelapor !== Auth::user()->email) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan pengaduan ini.');
        }

        // Cek status yang bisa dibatalkan
        if (!in_array($pengaduan->status_pengaduan, ['pending', 'butuh_bukti'])) {
            return redirect()->back()->with('error', 'Pengaduan dengan status ini tidak dapat dibatalkan.');
        }

        $pengaduan->update(['status_pengaduan' => 'dibatalkan']);

        return redirect()->route('whistleblower.dashboard')
            ->with('success', 'Pengaduan berhasil dibatalkan.');
    }

    // Method yang sudah ada sebelumnya tetap sama...
    public function index()
    {
        $user = Auth::user();
        $pengaduan = Pengaduan::where('email_pelapor', $user->email)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('whistleblower.user.index', compact('pengaduan'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(['kategori', 'terlapor'])->findOrFail($id);
        
        // Check access permissions
        if (!$this->checkUserRole() && $pengaduan->email_pelapor !== Auth::user()->email) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk melihat pengaduan ini.');
        }

        return view('whistleblower.user.show', compact('pengaduan'));
    }

    public function adminIndex()
    {
        if (!$this->checkUserRole()) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        $pengaduan = Pengaduan::with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('whistleblower.admin.index', compact('pengaduan'));
    }

    public function adminPending()
    {
        if (!$this->checkUserRole()) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        $pengaduan = Pengaduan::where('status_pengaduan', 'pending')
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('whistleblower.admin.pending', compact('pengaduan'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (!$this->checkUserRole()) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'status_pengaduan' => 'required|in:pending,proses,selesai,ditolak,butuh_bukti',
            'catatan_admin' => 'nullable|string'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'status_pengaduan' => $request->status_pengaduan,
            'catatan_admin' => $request->catatan_admin,
            'updated_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Status pengaduan berhasil diupdate.');
    }

    // Method lain yang sudah ada tetap sama...
    public function kategoriIndex()
    {
        if (!$this->checkUserRole()) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        $kategori = KategoriPengaduan::orderBy('nama_kategori')->get();
        return view('whistleblower.admin.kategori', compact('kategori'));
    }

    public function kategoriStore(Request $request)
    {
        if (!$this->checkUserRole()) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:ref_kategori_pengaduan',
            'deskripsi_kategori' => 'nullable|string'
        ]);

        KategoriPengaduan::create($request->all());

        return redirect()->back()
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function kategoriUpdate(Request $request, $id)
    {
        if (!$this->checkUserRole()) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:ref_kategori_pengaduan,nama_kategori,' . $id,
            'deskripsi_kategori' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $kategori = KategoriPengaduan::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->back()
            ->with('success', 'Kategori berhasil diupdate.');
    }

    public function kategoriDestroy($id)
    {
        if (!$this->checkUserRole()) {
            return redirect()->route('whistleblower.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        $kategori = KategoriPengaduan::findOrFail($id);
        
        // Cek apakah kategori digunakan
        if ($kategori->pengaduan()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan.');
        }

        $kategori->delete();

        return redirect()->back()
            ->with('success', 'Kategori berhasil dihapus.');
    }
}