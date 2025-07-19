{{-- resources/views/whistleblower/partials/form-anonim.blade.php --}}
<!-- Opsi Anonim -->
<div class="mb-4">
    <div class="card bg-light">
        <div class="card-body">
            <div class="form-check">
                <input type="checkbox" name="is_anonim" id="is_anonim" 
                       class="form-check-input" value="1" 
                       {{ old('is_anonim') ? 'checked' : '' }}>
                <label for="is_anonim" class="form-check-label">
                    <strong>Kirim sebagai pengaduan anonim</strong>
                </label>
            </div>
            <small class="text-muted">
                Jika dicentang, identitas Anda akan disembunyikan dari laporan. 
                Namun, tim PPKPT tetap dapat menghubungi Anda jika diperlukan.
            </small>
        </div>
    </div>
</div>