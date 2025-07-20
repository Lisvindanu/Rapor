{{-- resources/views/whistleblower/partials/form-header.blade.php --}}
<div class="card mb-4">
    <div class="card-body text-center">
        <h3 class="card-title">Form Pelaporan</h3>
        <p class="card-text">
            Form ini digunakan untuk melaporkan tindakan kekerasan seksual, diskriminasi, dan perundungan di lingkungan
            Universitas Pasundan.
        </p>
        <div class="mt-3">
            <small class="text-muted">
                <i class="fas fa-user"></i>
                Pelapor: <strong>{{ $user->name ?? 'N/A' }}</strong>
            </small>
            <br>
            <small class="text-info">
                <i class="fas fa-envelope"></i>
                Email: <strong>{{ $user->email ?? 'N/A' }}</strong>
            </small>
        </div>
    </div>
</div>

<!-- Alert Informasi -->
<div class="alert alert-info mb-4">
    <h6><i class="fas fa-info-circle"></i> Informasi Penting:</h6>
    <ul class="mb-0">
        <li>Pastikan informasi yang Anda berikan benar dan akurat</li>
        <li>Anda dapat memilih untuk melapor secara anonim</li>
        <li>Bukti pendukung wajib dilampirkan</li>
        <li>Laporan akan ditindaklanjuti sesuai dengan prosedur yang berlaku</li>
    </ul>
</div>
