{{-- resources/views/whistleblower/partials/form-alasan-pengaduan.blade.php --}}
<div class="form-section mb-4">
    <h6 class="section-title">
        <i class="fas fa-question-circle"></i>
        Alasan pengaduan (Silakan centang satu atau lebih pilihan berikut)
    </h6>

    <div class="checkbox-group">
        <div class="form-check mb-2">
            <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
                   type="checkbox" name="alasan_pengaduan[]" 
                   value="saksi_khawatir" id="alasan1"
                   {{ in_array('saksi_khawatir', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan1">
                Saya seorang saksi yang khawatir dengan keadaan Korban
            </label>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
                   type="checkbox" name="alasan_pengaduan[]" 
                   value="korban_bantuan" id="alasan2"
                   {{ in_array('korban_bantuan', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan2">
                Saya seorang Korban yang memerlukan bantuan pemulihan
            </label>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
                   type="checkbox" name="alasan_pengaduan[]" 
                   value="tindak_tegas" id="alasan3"
                   {{ in_array('tindak_tegas', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan3">
                Saya ingin Perguruan Tinggi menindak tegas Terlapor
            </label>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
                   type="checkbox" name="alasan_pengaduan[]" 
                   value="dokumentasi_keamanan" id="alasan4"
                   {{ in_array('dokumentasi_keamanan', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan4">
                Saya ingin Satuan Tugas mendokumentasikan kejadiannya, meningkatkan keamanan Perguruan Tinggi dari Kekerasan, dan memberi pelindungan bagi saya
            </label>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
                   type="checkbox" name="alasan_pengaduan[]" 
                   value="lainnya" id="alasan5"
                   {{ in_array('lainnya', old('alasan_pengaduan', [])) ? 'checked' : '' }}>
            <label class="form-check-label" for="alasan5">
                Lainnya
            </label>
        </div>
    </div>

    @error('alasan_pengaduan')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    <small class="form-text text-muted">
        <i class="fas fa-info-circle"></i>
        Pilih minimal satu alasan yang sesuai dengan situasi Anda
    </small>
</div>