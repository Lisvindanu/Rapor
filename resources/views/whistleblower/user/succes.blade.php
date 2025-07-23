{{-- resources/views/whistleblower/user/success.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h2 class="text-success mb-3">Pengaduan Berhasil Dikirim!</h2>
                    
                    <div class="alert alert-info">
                        <h5 class="mb-3">
                            <i class="fas fa-info-circle"></i>
                            Kode Pengaduan Anda
                        </h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <code class="fs-4 text-primary bg-light px-3 py-2 rounded" id="kodePengaduan">
                                {{ $pengaduan->kode_pengaduan }}
                            </code>
                            <button class="btn btn-outline-primary btn-sm ms-2" onclick="copyKode()" title="Copy kode">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            Simpan kode ini untuk melacak status pengaduan Anda
                        </small>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6><i class="fas fa-clock text-warning"></i> Status Saat Ini</h6>
                                    <span class="badge bg-warning">Menunggu Review</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6><i class="fas fa-calendar text-info"></i> Tanggal Pengaduan</h6>
                                    <small>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6>Langkah Selanjutnya:</h6>
                        <ul class="list-unstyled text-start">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Tim PPKPT akan melakukan review awal dalam 2-3 hari kerja
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                Anda akan menerima konfirmasi melalui email: <strong>{{ Auth::user()->email }}</strong>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-search text-info me-2"></i>
                                Proses investigasi akan dimulai sesuai prosedur yang berlaku
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-phone text-warning me-2"></i>
                                Tim mungkin akan menghubungi Anda untuk klarifikasi lebih lanjut
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('whistleblower.dashboard') }}" class="btn btn-primary me-2">
                            <i class="fas fa-tachometer-alt"></i> Ke Dashboard
                        </a>
                        <a href="{{ route('whistleblower.show', $pengaduan->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-muted">Butuh Bantuan?</h6>
                        <p class="small text-muted mb-2">
                            Hubungi Tim PPKPT jika ada pertanyaan atau keluhan
                        </p>
                        <div>
                            <a href="mailto:ppkpt@unpas.ac.id" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fas fa-envelope"></i> ppkpt@unpas.ac.id
                            </a>
                            <a href="tel:+622220193300" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-phone"></i> (022) 2019-3300
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyKode() {
    const kode = document.getElementById('kodePengaduan').textContent.trim();
    navigator.clipboard.writeText(kode).then(function() {
        // Show success feedback
        const btn = event.target.closest('button');
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalHtml;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    }).catch(function(err) {
        alert('Gagal menyalin kode: ' + err);
    });
}
</script>
@endsection