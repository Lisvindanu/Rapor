{{-- resources/views/whistleblower/partials/form-header.blade.php --}}
<div class="alert alert-info border-left-primary mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="mb-1">
                <i class="fas fa-info-circle"></i>
                Informasi Pelapor
            </h6>
            <p class="mb-0 small">
                Anda sedang login sebagai: <strong>{{ $user->email }}</strong>
            </p>
        </div>
        <div class="col-md-4 text-md-end">
            <small class="text-muted">
                <i class="fas fa-shield-alt"></i>
                Data akan dijaga kerahasiaannya
            </small>
        </div>
    </div>
</div>

<div class="alert alert-warning">
    <h6><i class="fas fa-exclamation-triangle"></i> Panduan Pelaporan</h6>
    <ul class="mb-0 small">
        <li>Pastikan informasi yang disampaikan adalah <strong>benar dan dapat dipertanggungjawabkan</strong></li>
        <li>Lampirkan bukti pendukung (file atau link Google Drive) yang <strong>wajib</strong> disertakan</li>
        <li>Tim PPKPT akan merahasiakan identitas pelapor sesuai kebijakan yang berlaku</li>
        <li>Proses investigasi akan dilakukan secara objektif dan profesional</li>
    </ul>
</div>