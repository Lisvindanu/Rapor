{{-- resources/views/whistleblower/partials/form-detail-peristiwa.blade.php --}}
<div class="form-section">
    <h5 class="mb-3">
        <i class="fas fa-file-alt"></i> Detail Peristiwa
    </h5>

    <div class="mb-3">
        <label for="judul_pengaduan" class="form-label fw-bold">
            Judul Pengaduan <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control @error('judul_pengaduan') is-invalid @enderror" 
               id="judul_pengaduan" name="judul_pengaduan" 
               value="{{ old('judul_pengaduan') }}" required>
        @error('judul_pengaduan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="cerita_singkat" class="form-label fw-bold">
            Cerita singkat peristiwa (tanggal kejadian, lokasi, detail peristiwa) <span class="text-danger">*</span>
        </label>
        <textarea class="form-control @error('cerita_singkat_peristiwa') is-invalid @enderror" 
                  id="cerita_singkat" name="cerita_singkat_peristiwa" rows="5" required 
                  placeholder="Jelaskan secara detail peristiwa yang terjadi, termasuk tanggal, lokasi, dan kronologi kejadian...">{{ old('cerita_singkat_peristiwa') }}</textarea>
        @error('cerita_singkat_peristiwa')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
                <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" 
                       id="tanggal_kejadian" name="tanggal_kejadian" 
                       value="{{ old('tanggal_kejadian') }}" max="{{ date('Y-m-d') }}">
                @error('tanggal_kejadian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian</label>
                <input type="text" class="form-control @error('lokasi_kejadian') is-invalid @enderror" 
                       id="lokasi_kejadian" name="lokasi_kejadian" 
                       value="{{ old('lokasi_kejadian') }}" 
                       placeholder="Contoh: Gedung A Lantai 2, Ruang Dosen">
                @error('lokasi_kejadian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="kategori_id" class="form-label fw-bold">
            Kategori Pengaduan <span class="text-danger">*</span>
        </label>
        <select class="form-select @error('kategori_id') is-invalid @enderror" 
                id="kategori_id" name="kategori_id" required>
            <option value="">Pilih Kategori</option>
            @foreach($kategori as $kat)
                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                    {{ $kat->nama }}
                </option>
            @endforeach
        </select>
        @error('kategori_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>