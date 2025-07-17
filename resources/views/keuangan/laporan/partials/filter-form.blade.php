<div class="filter-konten">
    <div class="row justify-content-md-center">
        <div class="container">
            <form action="{{ route('keuangan.laporan.print') }}" method="POST" id="laporanForm">
                @csrf
                <div class="card">
                    <div class="card-header" style="background-color: #fff; margin-top:10px">
                        <h5 class="card-title">Filter Laporan</h5>
                    </div>
                    <div class="card-body">
                        {{-- Horizontal Layout - All in one row --}}
                        <div class="row">
                            {{-- Periode Selection --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kode_periode">Periode <span class="text-danger">*</span></label>
                                    <select class="form-control" name="kode_periode" id="kode_periode" required>
                                        <option value="">Pilih Periode</option>
                                        @foreach ($daftar_periode as $periode)
                                            <option value="{{ $periode->kode_periode }}">
                                                {{ $periode->kode_periode }} - {{ $periode->nama_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Report Type Selection --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama_laporan">Jenis Laporan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="nama_laporan" id="nama_laporan" required>
                                        <option value="">Pilih Jenis Laporan</option>
                                        <optgroup label="Laporan Utama">
                                            <option value="jurnal-pengeluaran">Jurnal Pengeluaran Anggaran</option>
                                            <option value="jurnal-per-mata-anggaran">Jurnal Per Mata Anggaran</option>
                                            <option value="buku-besar">Buku Besar</option>
                                            <option value="buku-kas">Bukti Pengeluaran Kas</option>
                                        </optgroup>
                                        <optgroup label="Laporan Khusus">
                                            <option value="pembayaran-tugas-akhir">Pembayaran Tugas Akhir</option>
                                            <option value="honor-koreksi">Honor Koreksi</option>
                                            <option value="honor-vakasi">Honor & Vakasi</option>
                                            <option value="pengeluaran-fakultas">Pengeluaran Fakultas</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            {{-- Program Studi Selection --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="programstudi">Program Studi <span class="text-danger">*</span></label>
                                    <select class="form-control" name="programstudi" id="programstudi" required>
                                        <option value="">Pilih Program Studi</option>
                                        @if(isset($unitkerja) && $unitkerja)
                                            <option value="{{ $unitkerja->id }}">{{ $unitkerja->nama_unit }}</option>
                                            @if($unitkerja->childUnit && count($unitkerja->childUnit) > 0)
                                                @foreach($unitkerja->childUnit as $child)
                                                    <option value="{{ $child->id }}">{{ $child->nama_unit }}</option>
                                                @endforeach
                                            @endif
                                        @else
                                            <option value="all">Semua Program Studi</option>
                                            <option value="fakultas-teknik">FAKULTAS TEKNIK</option>
                                            <option value="teknik-informatika">Teknik Informatika</option>
                                            <option value="teknik-lingkungan">Teknik Lingkungan</option>
                                            <option value="teknik-mesin">Teknik Mesin</option>
                                            <option value="perencanaan-wilayah">Perencanaan Wilayah dan Kota</option>
                                            <option value="teknik-industri">Teknik Industri</option>
                                            <option value="teknologi-pangan">Teknologi Pangan</option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">
                                        Mohon pilih program studi terlebih dahulu
                                    </div>
                                </div>
                            </div>

                            {{-- Export Format Selection --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="format_export">Format Export <span class="text-danger">*</span></label>
                                    <select class="form-control" name="format_export" id="format_export" required>
                                        <option value="">Pilih Format</option>
                                        <option value="excel">Excel (.xlsx)</option>
                                        <option value="pdf">PDF (.pdf)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="btn-group-laporan">
                            <button type="button" class="btn btn-info" id="btnPreview">
                                <i class="fas fa-eye"></i> Preview
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download"></i> Generate & Download
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
