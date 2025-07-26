{{-- resources/views/whistleblower/user/partials/form-persetujuan.blade.php --}}
<div class="form-section mt-3 mb-4">
    <h6><i class="fas fa-shield-alt me-2"></i>Persetujuan</h6>

    <div class="form-check">
        <input type="checkbox" class="form-check-input @error('persetujuan_kebijakan') is-invalid @enderror"
            id="persetujuan_kebijakan" name="persetujuan_kebijakan" value="1" required
            {{ old('persetujuan_kebijakan') ? 'checked' : '' }}>
        <label class="form-check-label" for="persetujuan_kebijakan">
            Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#modalKebijakan">Kebijakan
                Privasi</a>
            dan memahami bahwa informasi yang saya berikan akan digunakan untuk proses investigasi <span
                class="text-danger">*</span>
        </label>
        @error('persetujuan_kebijakan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
