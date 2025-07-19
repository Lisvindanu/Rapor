{{-- resources/views/whistleblower/partials/form-anonim.blade.php --}}
<div class="mb-4">
    <div class="card bg-light border">
        <div class="card-body">
            <h6 class="card-title fw-bold">
                <i class="fas fa-user-secret me-2"></i>Opsi Anonimitas
            </h6>
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="submit_anonim" name="submit_anonim" 
                       {{ old('submit_anonim') ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="submit_anonim">
                    Submit sebagai Anonim
                </label>
            </div>
            
            <div class="alert alert-info">
                <small>
                    <i class="fas fa-info-circle me-1"></i>
                    Jika dicentang, nama Anda akan ditampilkan sebagai <strong>"Anonim"</strong> dalam sistem. 
                    Namun email dan data lainnya tetap akan tersimpan untuk keperluan tindak lanjut dan verifikasi.
                </small>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <label for="nama_display" class="form-label">Nama yang akan ditampilkan:</label>
                    <input type="text" class="form-control" id="nama_display" readonly 
                           value="{{ old('submit_anonim') ? 'Anonim' : Auth::user()->name }}"
                           style="background-color: #e9ecef;">
                </div>
                <div class="col-md-6">
                    <label for="email_display" class="form-label">Email (tetap tersimpan):</label>
                    <input type="text" class="form-control" id="email_display" readonly 
                           value="{{ Auth::user()->email }}"
                           style="background-color: #e9ecef;">
                </div>
            </div>
            
            <input type="hidden" name="nama_pelapor" id="nama_pelapor" 
                   value="{{ old('submit_anonim') ? 'Anonim' : Auth::user()->name }}">
        </div>
    </div>
</div>