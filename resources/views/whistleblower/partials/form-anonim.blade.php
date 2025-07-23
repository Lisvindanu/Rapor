{{-- resources/views/whistleblower/partials/form-anonim.blade.php --}}
<div class="form-section mb-4">
    <h6 class="section-title">
        <i class="fas fa-user-secret"></i>
        Opsi Pelaporan
    </h6>
    
    <div class="anonim-option-card">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" 
                   id="submit_anonim" name="submit_anonim" value="1"
                   {{ old('submit_anonim') ? 'checked' : '' }}>
            <label class="form-check-label" for="submit_anonim">
                <strong>Kirim laporan secara anonim</strong>
            </label>
        </div>
        
        <div class="anonim-info mt-3">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Catatan Penting:</strong>
                <ul class="mt-2 mb-0">
                    <li>Jika Anda memilih untuk melapor secara anonim, <strong>nama Anda akan disembunyikan</strong> dalam laporan</li>
                    <li>Namun, <strong>email Anda tetap akan tercatat</strong> untuk keperluan administratif dan follow-up jika diperlukan</li>
                    <li>Tim PPKPT tetap dapat menghubungi Anda melalui email untuk klarifikasi lebih lanjut</li>
                    <li>Data pribadi lainnya (detail peristiwa, bukti, dll) tetap akan disimpan dan diproses sesuai prosedur</li>
                </ul>
            </div>
        </div>

        <div class="anonim-benefits mt-3">
            <h6 class="small mb-2"><i class="fas fa-shield-alt"></i> Keuntungan Pelaporan Anonim:</h6>
            <div class="row">
                <div class="col-md-6">
                    <ul class="small mb-0">
                        <li>Identitas terlindungi dari pihak yang dilaporkan</li>
                        <li>Mengurangi risiko retaliasi</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="small mb-0">
                        <li>Tetap dapat dihubungi untuk klarifikasi</li>
                        <li>Proses investigasi tetap dapat berjalan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>