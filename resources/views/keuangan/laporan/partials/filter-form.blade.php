<div class="filter-konten">
    <div class="row justify-content-md-center">
        <div class="col-8">
            <form action="{{ route('keuangan.laporan.print') }}" method="POST" id="laporanForm">
                @csrf
                <div class="card">
                    <div class="card-header" style="background-color: #fff; margin-top:10px">
                        <h5 class="card-title">Filter Laporan</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            {{-- Periode Selection --}}
                            <div class="form-group col-md-6">
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

                            {{-- Report Type Selection --}}
                            <div class="form-group col-md-6">
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

                        <div class="form-row">
                            {{-- Program Studi Selection --}}
                            <div class="form-group col-md-6">
                                <label for="programstudi">Program Studi <span class="text-danger">*</span></label>
                                <select class="form-control" name="programstudi[]" id="programstudi" multiple required>
                                    @if(isset($unitkerja))
                                        <option value="{{ $unitkerja->id }}" selected>{{ $unitkerja->nama }}</option>
                                        @if($unitkerja->childUnit && count($unitkerja->childUnit) > 0)
                                            @foreach($unitkerja->childUnit as $child)
                                                <option value="{{ $child->id }}">{{ $child->nama }}</option>
                                            @endforeach
                                        @endif
                                    @else
                                        <option value="all">Semua Program Studi</option>
                                    @endif
                                </select>
                                <small class="form-text text-muted">Ctrl + Click untuk pilih multiple</small>
                            </div>

                            {{-- Export Format Selection --}}
                            <div class="form-group col-md-6">
                                <label for="format_export">Format Export <span class="text-danger">*</span></label>
                                <select class="form-control" name="format_export" id="format_export" required>
                                    <option value="">Pilih Format</option>
                                    <option value="excel">Excel (.xlsx)</option>
                                    <option value="pdf">PDF (.pdf)</option>
                                </select>
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
