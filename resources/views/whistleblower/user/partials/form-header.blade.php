{{-- resources/views/whistleblower/user/partials/form-header.blade.php --}}
<div class="text-center mb-4">
    <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin-bottom: 8px;">
        Form Laporan Pengaduan
    </h1>
    <p style="color: #6b7280; font-size: 16px; margin-bottom: 12px;">
        Laporkan dugaan pelanggaran yang Anda ketahui
    </p>
    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; padding: 8px 12px; display: inline-block;">
        <i class="fas fa-user" style="color: #3b82f6; margin-right: 6px;"></i>
        <span style="color: #1e40af; font-weight: 500;">{{ auth()->user()->email }}</span>
    </div>
</div>