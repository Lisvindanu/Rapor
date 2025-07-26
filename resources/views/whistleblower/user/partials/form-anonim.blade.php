{{-- resources/views/whistleblower/user/partials/form-anonim.blade.php --}}
<div class="form-section">
    <h6><i class="fas fa-user-secret me-2"></i>Opsi Pelaporan</h6>
    
    <div class="form-check">
        <input type="checkbox" class="form-check-input" 
               id="submit_anonim" name="submit_anonim" value="1"
               {{ old('submit_anonim') ? 'checked' : '' }}>
        <label class="form-check-label" for="submit_anonim">
            <strong>Kirim sebagai Anonim</strong>
        </label>
        <div class="form-text">
            Jika dicentang, identitas Anda akan disembunyikan dalam laporan ini. 
            Nama akan ditampilkan sebagai "Anonim" tapi data lainnya tetap tersimpan untuk keperluan investigasi.
        </div>
    </div>
</div>