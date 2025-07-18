{{-- resources/views/whistleblower/create.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2>Buat Pengaduan Baru</h2>
                <p class="text-muted">Laporkan insiden yang Anda alami atau saksikan dengan aman dan rahasia</p>
            </div>

            <!-- Alert Informasi -->
            <div class="alert alert-info mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-shield-alt"></i> Kerahasiaan Terjamin</h6>
                        <small>Identitas Anda akan dijaga kerahasiaannya</small>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-clock"></i> Respon Cepat</h6>
                        <small>Tim akan merespons dalam 3x24 jam</small>
                    </div>
                </div>
            </div>

            <!-- Form Pengaduan -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit"></i> Form Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('whistleblower.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Kategori Pengaduan -->
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">
                                Kategori Pengaduan <span class="text-danger">*</span>
                            </label>
                            <select name="kategori_id" id="kategori_id" 
                                    class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori Pengaduan</option>
                                @foreach($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>Pilih kategori yang paling sesuai dengan insiden yang terjadi</small>
                            </div>
                        </div>

                        <!-- Judul Pengaduan -->
                        <div class="mb-3">
                            <label for="judul_pengaduan" class="form-label">
                                Judul Pengaduan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="judul_pengaduan" id="judul_pengaduan" 
                                   class="form-control @error('judul_pengaduan') is-invalid @enderror"
                                   value="{{ old('judul_pengaduan') }}" 
                                   placeholder="Berikan judul singkat untuk pengaduan Anda" required>
                            @error('judul_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi Pengaduan -->
                        <div class="mb-3">
                            <label for="deskripsi_pengaduan" class="form-label">
                                Deskripsi Pengaduan <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi_pengaduan" id="deskripsi_pengaduan" 
                                      class="form-control @error('deskripsi_pengaduan') is-invalid @enderror"
                                      rows="6" placeholder="Jelaskan secara detail apa yang terjadi..." required>{{ old('deskripsi_pengaduan') }}</textarea>
                            @error('deskripsi_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>
                                    Berikan informasi selengkap mungkin: waktu, tempat, orang yang terlibat, 
                                    kronologi kejadian, dan dampak yang dirasakan.
                                </small>
                            </div>
                        </div>

                        <!-- Upload Bukti -->
                        <div class="mb-3">
                            <label for="evidence" class="form-label">
                                Upload Bukti (Opsional)
                            </label>
                            <input type="file" name="evidence" id="evidence" 
                                   class="form-control @error('evidence') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            @error('evidence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>
                                    Format yang diizinkan: JPG, PNG, PDF, DOC, DOCX. Maksimal 5MB.
                                    <br>Semua bukti akan disimpan dengan aman dan hanya dapat diakses oleh tim PPKPT.
                                </small>
                            </div>
                        </div>

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

                        <!-- Persetujuan -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="agreement" id="agreement" 
                                       class="form-check-input" required>
                                <label for="agreement" class="form-check-label">
                                    Saya menyatakan bahwa informasi yang saya berikan adalah benar dan 
                                    saya memahami <a href="#" data-bs-toggle="modal" data-bs-target="#modalKebijakan">
                                    kebijakan privasi</a> yang berlaku. <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('whistleblower.user.dashboard') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kebijakan -->
<div class="modal fade" id="modalKebijakan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kebijakan Privasi & Perlindungan Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Perlindungan Identitas</h6>
                <ul>
                    <li>Identitas pelapor akan dijaga kerahasiaannya</li>
                    <li>Data pribadi hanya dapat diakses oleh tim PPKPT yang berwenang</li>
                    <li>Tidak ada tindakan balasan untuk pelapor yang beritikad baik</li>
                </ul>
                
                <h6>Penggunaan Data</h6>
                <ul>
                    <li>Data pengaduan hanya digunakan untuk proses investigasi</li>
                    <li>Informasi tidak akan disebarluaskan tanpa persetujuan</li>
                    <li>Data disimpan sesuai dengan ketentuan peraturan yang berlaku</li>
                </ul>
                
                <h6>Hak Pelapor</h6>
                <ul>
                    <li>Mendapat perlindungan dari tindakan balasan</li>
                    <li>Mendapat informasi tentang progress pengaduan</li>
                    <li>Mendapat pendampingan jika diperlukan</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
            </div>
        </div>
    </div>
</div>
@endsection