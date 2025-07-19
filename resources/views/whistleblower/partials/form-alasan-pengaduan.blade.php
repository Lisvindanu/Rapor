{{-- resources/views/whistleblower/partials/form-alasan-pengaduan.blade.php --}}
<div class="mb-4">
    <label class="form-label fw-bold">
        Alasan pengaduan (Silakan centang satu atau lebih pilihan berikut) <span class="text-danger">*</span>
    </label>
    
    <div class="mt-3">
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" value="saksi_khawatir" id="alasan_saksi"
                   {{ is_array(old('alasan_pengaduan')) && in_array('saksi_khawatir', old('alasan_pengaduan')) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan_saksi">
                Saya seorang saksi yang khawatir dengan keadaan Korban
            </label>
        </div>
        
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" value="korban_bantuan" id="alasan_korban"
                   {{ is_array(old('alasan_pengaduan')) && in_array('korban_bantuan', old('alasan_pengaduan')) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan_korban">
                Saya seorang Korban yang memerlukan bantuan pemulihan
            </label>
        </div>
        
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" value="tindak_tegas" id="alasan_tindak"
                   {{ is_array(old('alasan_pengaduan')) && in_array('tindak_tegas', old('alasan_pengaduan')) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan_tindak">
                Saya ingin Perguruan Tinggi menindak tegas Terlapor
            </label>
        </div>
        
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" value="dokumentasi_keamanan" id="alasan_dokumentasi"
                   {{ is_array(old('alasan_pengaduan')) && in_array('dokumentasi_keamanan', old('alasan_pengaduan')) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan_dokumentasi">
                Saya ingin Satuan Tugas mendokumentasikan kejadiannya, meningkatkan keamanan Perguruan Tinggi dari Kekerasan, dan memberi pelindungan bagi saya
            </label>
        </div>
        
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="alasan_pengaduan[]" value="lainnya" id="alasan_lainnya"
                   {{ is_array(old('alasan_pengaduan')) && in_array('lainnya', old('alasan_pengaduan')) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan_lainnya">
                Lainnya
            </label>
        </div>
    </div>
    
    @error('alasan_pengaduan')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    
    <small class="form-text text-muted">
        <i class="fas fa-info-circle me-1"></i>
        Pilih minimal satu alasan yang sesuai dengan situasi Anda
    </small>
</div>