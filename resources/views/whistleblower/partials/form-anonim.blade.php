{{-- resources/views/whistleblower/partials/form-anonim.blade.php --}}
<div class="mb-4">
    <h6 class="border-bottom pb-2 mb-3">Opsi Pelaporan</h6>
    
    <div class="border rounded p-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" 
                   id="submit_anonim" name="submit_anonim" value="1"
                   {{ old('submit_anonim') ? 'checked' : '' }}>
            <label class="form-check-label" for="submit_anonim">
                <strong>Kirim laporan secara anonim</strong>
            </label>
        </div>
        
        <div class="mt-3">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Catatan Penting:</strong>
                <ul class="mt-2 mb-0">
                    <li>Jika Anda memilih untuk melapor secara anonim, nama Anda akan disembunyikan dalam laporan</li>
                    <li>Namun, email Anda tetap akan tercatat untuk keperluan administratif dan follow-up jika diperlukan</li>
                    <li>Tim PPKPT tetap dapat menghubungi Anda melalui email untuk klarifikasi lebih lanjut</li>
                </ul>
            </div>
        </div>
    </div>
</div>