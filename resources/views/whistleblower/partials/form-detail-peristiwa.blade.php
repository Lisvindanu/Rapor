{{-- resources/views/whistleblower/partials/form-detail-peristiwa.blade.php --}}
<div class="mb-4">
    <h6 class="border-bottom pb-2 mb-3">Detail Peristiwa</h6>
    
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kategori_pengaduan_id" class="form-label">Kategori Pengaduan <span class="text-danger">*</span></label>
            <select class="form-select @error('kategori_pengaduan_id') is-invalid @enderror" 
                    id="kategori_pengaduan_id" name="kategori_pengaduan_id" required>
                <option value="">Pilih Kategori</option>
                @forelse($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_pengaduan_id') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @empty
                    <option value="" disabled>Tidak ada kategori tersedia</option>
                @endforelse
            </select>
            @error('kategori_pengaduan_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
            <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" 
                   id="tanggal_kejadian" name="tanggal_kejadian" 
                   value="{{ old('tanggal_kejadian') }}">
            @error('tanggal_kejadian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian</label>
            <input type="text" class="form-control @error('lokasi_kejadian') is-invalid @enderror" 
                   id="lokasi_kejadian" name="lokasi_kejadian" 
                   value="{{ old('lokasi_kejadian') }}"
                   placeholder="Contoh: Gedung A Lantai 2">
            @error('lokasi_kejadian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 mb-3">
            <label for="cerita_singkat_peristiwa" class="form-label">
                Cerita singkat peristiwa (tanggal kejadian, lokasi, detail peristiwa) <span class="text-danger">*</span>
            </label>
            <textarea class="form-control @error('cerita_singkat_peristiwa') is-invalid @enderror" 
                      id="cerita_singkat_peristiwa" name="cerita_singkat_peristiwa" 
                      rows="5" required 
                      placeholder="Jelaskan secara detail kronologi peristiwa yang terjadi...">{{ old('cerita_singkat_peristiwa') }}</textarea>
            @error('cerita_singkat_peristiwa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 mb-3">
            <label for="deskripsi_pengaduan" class="form-label">Deskripsi Tambahan (Opsional)</label>
            <textarea class="form-control @error('deskripsi_pengaduan') is-invalid @enderror" 
                      id="deskripsi_pengaduan" name="deskripsi_pengaduan" 
                      rows="3" 
                      placeholder="Informasi tambahan yang mendukung laporan...">{{ old('deskripsi_pengaduan') }}</textarea>
            @error('deskripsi_pengaduan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>