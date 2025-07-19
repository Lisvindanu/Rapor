{{-- resources/views/whistleblower/partials/form-header.blade.php --}}
<div class="alert alert-info mb-4">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h5 class="alert-heading mb-2">
                <i class="fas fa-shield-alt me-2"></i>
                Formulir Pengaduan Whistleblower
            </h5>
            <p class="mb-0">
                Silakan isi formulir dengan lengkap dan jujur. Identitas Anda akan dijaga kerahasiaannya sesuai dengan kebijakan perlindungan pelapor.
            </p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary fs-6">
                <i class="fas fa-user me-2"></i>
                {{ Auth::user()->email }}
            </span>
        </div>
    </div>
    
    <hr class="my-3">
    
    <div class="row">
        <div class="col-md-12">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                <strong>Informasi Penting:</strong> Nama, email, dan data yang terkait dengan akun Google/sistem Anda akan direkam saat Anda mengupload file dan mengirimkan formulir ini.
            </small>
        </div>
    </div>
</div>