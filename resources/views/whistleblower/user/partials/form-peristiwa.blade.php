{{-- resources/views/whistleblower/user/partials/form-peristiwa.blade.php --}}
<div class="form-section">
    <h6><i class="fas fa-calendar-alt me-2"></i>Detail Peristiwa</h6>
    
    <div class="mb-3">
        <label for="kategori_pengaduan_id" class="form-label">Kategori Pengaduan <span class="text-danger">*</span></label>
        <select class="form-select @error('kategori_pengaduan_id') is-invalid @enderror" 
                id="kategori_pengaduan_id" name="kategori_pengaduan_id" required>
            <option value="">Pilih Kategori</option>
            @foreach($kategori_pengaduan as $kategori)
                <option value="{{ $kategori->id }}" 
                        {{ old('kategori_pengaduan_id') == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>
        @error('kategori_pengaduan_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" 
                   id="tanggal_kejadian" name="tanggal_kejadian" 
                   value="{{ old('tanggal_kejadian') }}" required>
            @error('tanggal_kejadian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('lokasi_kejadian') is-invalid @enderror" 
                   id="lokasi_kejadian" name="lokasi_kejadian" 
                   value="{{ old('lokasi_kejadian') }}" 
                   placeholder="Contoh: Gedung A Lantai 2" required>
            @error('lokasi_kejadian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="cerita_singkat_peristiwa" class="form-label">Cerita Singkat Peristiwa <span class="text-danger">*</span></label>
        <textarea class="form-control @error('cerita_singkat_peristiwa') is-invalid @enderror" 
                  id="cerita_singkat_peristiwa" name="cerita_singkat_peristiwa" 
                  rows="4" required 
                  placeholder="Jelaskan secara singkat kronologi peristiwa yang terjadi">{{ old('cerita_singkat_peristiwa') }}</textarea>
        @error('cerita_singkat_peristiwa')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>