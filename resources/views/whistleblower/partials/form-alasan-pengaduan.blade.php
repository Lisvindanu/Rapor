{{-- resources/views/whistleblower/partials/form-alasan-pengaduan.blade.php --}}
<!-- Alasan Pengaduan -->
<div class="mb-3">
    <label class="form-label">
        Alasan pengaduan (Silakan centang satu atau lebih pilihan berikut) <span class="text-danger">*</span>
    </label>
    
    @php $oldAlasan = old('alasan_pengaduan', []); @endphp
    
    <div class="form-check mb-2">
        <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
               type="checkbox" name="alasan_pengaduan[]" value="saksi_khawatir" id="alasan1"
               {{ in_array('saksi_khawatir', $oldAlasan) ? 'checked' : '' }}>
        <label class="form-check-label" for="alasan1">
            Saya seorang saksi yang khawatir dengan keadaan Korban
        </label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
               type="checkbox" name="alasan_pengaduan[]" value="korban_bantuan" id="alasan2"
               {{ in_array('korban_bantuan', $oldAlasan) ? 'checked' : '' }}>
        <label class="form-check-label" for="alasan2">
            Saya seorang Korban yang memerlukan bantuan pemulihan
        </label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
               type="checkbox" name="alasan_pengaduan[]" value="tindak_tegas" id="alasan3"
               {{ in_array('tindak_tegas', $oldAlasan) ? 'checked' : '' }}>
        <label class="form-check-label" for="alasan3">
            Saya ingin Perguruan Tinggi menindak tegas Terlapor
        </label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
               type="checkbox" name="alasan_pengaduan[]" value="dokumentasi_keamanan" id="alasan4"
               {{ in_array('dokumentasi_keamanan', $oldAlasan) ? 'checked' : '' }}>
        <label class="form-check-label" for="alasan4">
            Saya ingin Satuan Tugas mendokumentasikan kejadiannya, meningkatkan keamanan Perguruan Tinggi dari Kekerasan, dan memberi pelindungan bagi saya
        </label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
               type="checkbox" name="alasan_pengaduan[]" value="lainnya" id="alasan5"
               {{ in_array('lainnya', $oldAlasan) ? 'checked' : '' }}>
        <label class="form-check-label" for="alasan5">
            Lainnya
        </label>
    </div>

    @error('alasan_pengaduan')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>