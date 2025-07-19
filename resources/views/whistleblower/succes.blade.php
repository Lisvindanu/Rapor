{{-- resources/views/whistleblower/success.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-success">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-check-circle"></i> Pengaduan Berhasil Dikirim
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-check fa-4x text-success mb-3"></i>
                        <h5>Terima kasih atas laporan Anda!</h5>
                        <p class="text-muted">
                            Pengaduan Anda telah berhasil dikirim dan akan segera ditindaklanjuti oleh tim PPKPT.
                        </p>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Informasi Pengaduan</h6>
                        <div class="row">
                            <div class="col-md-6 text-start">
                                <strong>Kode Pengaduan:</strong>
                            </div>
                            <div class="col-md-6 text-start">
                                <span class="badge bg-primary fs-6">{{ $pengaduan->kode_pengaduan }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 text-start">
                                <strong>Tanggal Pengaduan:</strong>
                            </div>
                            <div class="col-md-6 text-start">
                                {{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i:s') }}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6 text-start">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-md-6 text-start">
                                <span class="badge bg-warning">{{ $pengaduan->status_label }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle"></i> Penting!</h6>
                        <p class="mb-1">
                            <strong>Simpan kode pengaduan</strong> <code>{{ $pengaduan->kode_pengaduan }}</code> untuk melacak status pengaduan Anda.
                        </p>
                        <small class="text-muted">
                            Anda dapat menggunakan kode ini untuk mengecek status pengaduan melalui menu "Cek Status" atau melihatnya di dashboard.
                        </small>
                    </div>

                    <div class="row text-start">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6><i class="fas fa-clock"></i> Waktu Respon</h6>
                                    <p class="mb-0">Tim PPKPT akan merespons dalam <strong>maksimal 3x24 jam</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6><i class="fas fa-shield-alt"></i> Kerahasiaan</h6>
                                    <p class="mb-0">Identitas Anda dijaga kerahasiaannya sesuai kebijakan PPKPT</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6>Langkah Selanjutnya:</h6>
                        <ol class="text-start">
                            <li>Tim PPKPT akan melakukan review awal pengaduan Anda</li>
                            <li>Jika diperlukan, tim akan meminta informasi atau bukti tambahan</li>
                            <li>Proses investigasi akan dilakukan sesuai prosedur yang berlaku</li>
                            <li>Anda akan mendapat update status melalui dashboard</li>
                        </ol>
                    </div>

                    <div class="mt-4">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('whistleblower.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-tachometer-alt"></i> Ke Dashboard
                            </a>
                            <a href="{{ route('whistleblower.show', $pengaduan->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                            <a href="{{ route('whistleblower.create') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-plus"></i> Buat Pengaduan Lain
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card mt-4">
                <div class="card-body text-center">
                    <h6><i class="fas fa-phone"></i> Butuh Bantuan?</h6>
                    <p class="mb-1">Jika Anda memerlukan bantuan atau memiliki pertanyaan:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <small>
                                <strong>Email:</strong> ppkpt@unpas.ac.id
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small>
                                <strong>Telepon:</strong> (022) 4233644 ext. 1234
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto copy to clipboard when code is clicked
document.addEventListener('DOMContentLoaded', function() {
    const codeElement = document.querySelector('code');
    if (codeElement) {
        codeElement.style.cursor = 'pointer';
        codeElement.title = 'Klik untuk copy';
        
        codeElement.addEventListener('click', function() {
            navigator.clipboard.writeText(this.textContent).then(function() {
                // Show temporary success message
                const originalText = codeElement.textContent;
                codeElement.textContent = 'Copied!';
                codeElement.style.color = '#28a745';
                
                setTimeout(function() {
                    codeElement.textContent = originalText;
                    codeElement.style.color = '';
                }, 2000);
            });
        });
    }
});
</script>
@endpush