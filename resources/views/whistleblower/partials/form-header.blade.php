{{-- resources/views/whistleblower/partials/form-header.blade.php --}}
<!-- Header -->
<div class="mb-4">
    <h2>Buat Pengaduan Baru</h2>
    <p class="text-muted">Laporkan insiden yang Anda alami atau saksikan dengan aman dan rahasia</p>
    
    <!-- Info Pelapor -->
    <div class="alert alert-light border">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="mb-1"><i class="fas fa-user-circle text-primary"></i> Informasi Pelapor</h6>
                <small class="text-muted">
                    <strong>Email:</strong> {{ auth()->user()->email }} <br>
                    <strong>Nama:</strong> {{ auth()->user()->name }}
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Alert Informasi -->
<div class="alert alert-info mb-4">
    <div class="row">
        <div class="col-md-6">
            <h6><i class="fas fa-shield-alt"></i> Kerahasiaan Terjamin</h6>
            <small>Identitas Anda akan dijaga kerahasiaannya</small>
        </div>
        <div class="col-md-6">
            <h6><i class="fas fa-clock"></i> Respon Cepat</h6>
            <small>Tim akan merespons dalam 3x24 jam</small>
        </div>
    </div>
</div>