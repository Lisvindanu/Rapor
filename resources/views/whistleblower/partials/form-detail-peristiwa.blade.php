{{-- resources/views/whistleblower/partials/form-detail-peristiwa.blade.php --}}
<div class="mb-4">
    <h6 class="fw-bold mb-3">
        <i class="fas fa-file-alt me-2"></i>Detail Peristiwa
    </h6>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="kategori_pengaduan_id" class="form-label fw-bold">
                Kategori Pengaduan <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="kategori_pengaduan_id" name="kategori_pengaduan_id" required>
                <option value="">Pilih Kategori</option>
                @if(isset($kategori) && $kategori->count() > 0)
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_pengaduan_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                @else
                    <option value="" disabled class="text-muted">Kategori belum tersedia - Hubungi administrator</option>
                @endif
            </select>
            @error('kategori_pengaduan_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            
            @if(!isset($kategori) || $kategori->count() == 0)
                <small class="text-danger">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Data kategori tidak ditemukan. Silakan hubungi administrator.
                </small>
            @endif
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
            <input type="date" class="form-control" id="tanggal_kejadian" name="tanggal_kejadian" 
                   value="{{ old('tanggal_kejadian') }}" max="{{ date('Y-m-d') }}">
            <small class="form-text text-muted">Kapan kejadian tersebut terjadi (opsional)</small>
            @error('tanggal_kejadian')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="mb-3">
        <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian</label>
        <input type="text" class="form-control" id="lokasi_kejadian" name="lokasi_kejadian" 
               placeholder="Contoh: Gedung A Lantai 2, Ruang 205, Kampus Utama" value="{{ old('lokasi_kejadian') }}">
        <small class="form-text text-muted">Dimana kejadian tersebut terjadi (opsional)</small>
        @error('lokasi_kejadian')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="cerita_singkat_peristiwa" class="form-label fw-bold">
            Cerita singkat peristiwa (tanggal kejadian, lokasi, detail peristiwa) <span class="text-danger">*</span>
        </label>
        <textarea class="form-control" id="cerita_singkat_peristiwa" name="cerita_singkat_peristiwa" rows="6" 
                  placeholder="Ceritakan secara detail kronologi kejadian yang Anda alami atau saksikan. Sertakan informasi berikut:&#10;&#10;1. Waktu kejadian (tanggal, hari, jam)&#10;2. Tempat kejadian yang spesifik&#10;3. Orang-orang yang terlibat&#10;4. Urutan kejadian secara kronologis&#10;5. Saksi yang melihat (jika ada)&#10;6. Dampak yang dirasakan&#10;&#10;Semakin detail informasi yang diberikan, semakin mudah untuk ditindaklanjuti." required>{{ old('cerita_singkat_peristiwa') }}</textarea>
        <div class="form-text">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                <strong>Tips:</strong> Ceritakan dengan detail dan objektif. Gunakan bahasa yang sopan dan hindari kata-kata kasar.
            </small>
        </div>
        @error('cerita_singkat_peristiwa')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="deskripsi_pengaduan" class="form-label">Informasi Tambahan (Opsional)</label>
        <textarea class="form-control" id="deskripsi_pengaduan" name="deskripsi_pengaduan" rows="4" 
                  placeholder="Tambahkan informasi lain yang relevan seperti:&#10;- Upaya penyelesaian yang sudah dilakukan&#10;- Dampak yang dirasakan&#10;- Harapan penyelesaian&#10;- Informasi lain yang mendukung laporan">{{ old('deskripsi_pengaduan') }}</textarea>
        <small class="form-text text-muted">
            Informasi tambahan yang dapat membantu proses penanganan
        </small>
        @error('deskripsi_pengaduan')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>