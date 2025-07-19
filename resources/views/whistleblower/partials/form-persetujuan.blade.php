{{-- resources/views/whistleblower/partials/form-persetujuan.blade.php --}}
<div class="mb-4">
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <h6 class="card-title mb-0">
                <i class="fas fa-shield-check me-2"></i>Persetujuan dan Kebijakan
            </h6>
        </div>
        <div class="card-body">
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="persetujuan_kebijakan" name="persetujuan_kebijakan" required
                       {{ old('persetujuan_kebijakan') ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="persetujuan_kebijakan">
                    Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#modalKebijakan" class="text-decoration-underline">Kebijakan Privasi</a> dan memahami bahwa informasi yang saya berikan akan digunakan untuk proses penanganan pengaduan <span class="text-danger">*</span>
                </label>
                @error('persetujuan_kebijakan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="alert alert-success mb-0">
                <h6 class="alert-heading">
                    <i class="fas fa-shield-alt me-2"></i>Jaminan Kerahasiaan
                </h6>
                <p class="mb-0">
                    Identitas dan informasi Anda akan dijaga sesuai dengan protokol keamanan dan kebijakan perlindungan pelapor yang berlaku di institusi.
                </p>
            </div>
        </div>
    </div>
</div>