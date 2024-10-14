@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('btq.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="judul-modul">
                    <span>
                        <h3>Jadwal Placement Test BTQ</h3>
                        <p>Detail jadwal BTQ</p>
                    </span>
                </div>
            </div>
        </div>

        @include('komponen.message-alert')

        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: #fff; margin-top:10px">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('btq') }}" class="btn btn-secondary" type="button">Kembali</a>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        @if ($penilaianMahasiswaExists)
                                            <button type="button" class="btn btn-danger" id="btnSimpan">Reset
                                                Penilaian</button>
                                        @else
                                            <button type="button" class="btn btn-primary" id="btnSimpan">Generate
                                                Penilaian</button>
                                        @endif
                                        <!-- Button simpan -->
                                        {{-- <button type="button" class="btn btn-primary" id="btnSimpan">Generate
                                            Penilaiain</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex;">
                        <div class="col-2">
                            @include('btq.jadwal.sidebar')
                        </div>
                        <div class="col-10">
                            <div class="sub-konten">
                                <div class="card">
                                    <div class="card-body" style="display: flex">
                                        <div class="col-md-12">
                                            <div class="table-container">
                                                <table class="table table-hover" id="editableTable">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th rowspan="2"
                                                                style="text-align: center;vertical-align: middle;">No.</th>
                                                            <th rowspan="2"
                                                                style="text-align: center;vertical-align: middle;">NIM</th>
                                                            <th rowspan="2"
                                                                style="text-align: center;vertical-align: middle;">Nama</th>
                                                            <th rowspan="2"
                                                                style="text-align: center;vertical-align: middle;">Program
                                                                Studi
                                                            </th>
                                                            <th colspan="3"
                                                                style="text-align: center;vertical-align: middle;">
                                                                Poin
                                                            </th>
                                                            <th rowspan="2"
                                                                style="text-align: center;vertical-align: middle;">
                                                                Penilaian
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th style="text-align: center;vertical-align: middle;">Bacaan
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">Tulisan
                                                            </th>
                                                            <th style="text-align: center;vertical-align: middle;">Hafalan
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tabel-body">
                                                        @forelse ($daftar_peserta as $index => $peserta)
                                                            <tr>
                                                                <td hidden>{{ $peserta->id }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $index + 1 }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $peserta->mahasiswa->nim }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $peserta->mahasiswa->nama }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    {{ $peserta->mahasiswa->programstudi }}</td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    @if ($peserta->nilai_bacaan)
                                                                        {{ $peserta->nilai_bacaan }}
                                                                    @else
                                                                        0
                                                                    @endif
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    @if ($peserta->nilai_tulisan)
                                                                        {{ $peserta->nilai_tulisan }}
                                                                    @else
                                                                        0
                                                                    @endif
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    @if ($peserta->nilai_hafalan)
                                                                        {{ $peserta->nilai_hafalan }}
                                                                    @else
                                                                        0
                                                                    @endif
                                                                </td>
                                                                <td style="text-align: center;vertical-align: middle;">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-warning btn-bacaan"
                                                                        data-mahasiswa-id="{{ $peserta->mahasiswa->id }}">Bacaan</button>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-success">Tulisan</button>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-info">Hafalan</button>
                                                                </td>

                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8"
                                                                    style="text-align: center;vertical-align: middle;">Tidak
                                                                    ada peserta terdaftar</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div> <!-- End card-body -->
                                </div> <!-- End card -->
                            </div> <!-- End sub-konten -->
                        </div> <!-- End col-10 -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="modalPenilaian" tabindex="-1" aria-labelledby="modalPenilaianLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPenilaianLabel">Penilaian Hafalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Pastikan data yang diinputkan sudah sesuai. checklist bila "Ya" dan kosongkan bila "Tidak".
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <table class="table table-bordered" id="tabelData">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Penilaian</th>
                                <th><input type="checkbox" id="checkAll"></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="modal fade" id="modalPenilaian" tabindex="-1" aria-labelledby="modalPenilaianLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPenilaianLabel">Penilaian Hafalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Pastikan data yang diinputkan sudah sesuai. checklist bila "Ya" dan kosongkan bila "Tidak".
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <table class="table table-bordered" id="tabelData">
                        <thead>
                            <tr>
                                <th style="text-align: center;vertical-align: middle;">No.</th>
                                <th>Penilaian</th>
                                <th style="text-align: center;vertical-align: middle;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimasukkan secara dinamis melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanPenilaian">Simpan</button>
                </div>
                <div id="loadingSpinner" class="spinner-border text-primary" role="status" style="display: none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            $('#btnSimpan').on('click', function() {
                // Tampilkan SweetAlert untuk konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Generate penilaian akan dilakukan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, lanjutkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user mengonfirmasi, lakukan request AJAX
                        $.ajax({
                            url: "{{ route('btq.penilaian.generate') }}", // Route yang akan dipanggil
                            type: 'POST',
                            data: {
                                // Jika ada data yang perlu dikirim, masukkan di sini
                                _token: "{{ csrf_token() }}",
                                jadwal_id: "{{ $jadwal->id }}"
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Penilaian berhasil digenerate.',
                                    'success'
                                ).then(() => {
                                    // Tutup modal dan reload halaman setelah SweetAlert ditutup
                                    $('#modalPenilaian').modal('hide');
                                    location.reload(); // Reload halaman
                                });
                            },
                            error: function(xhr, status, error) {
                                // Tindakan ketika gagal
                                Swal.fire(
                                    'Gagal!',
                                    xhr.responseJSON.message ||
                                    'Penilaian gagal di-generate.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });

        $('.btn-warning, .btn-info, .btn-success').on('click', function() {
            // Ambil jenis penilaian dari tombol yang diklik (Bacaan, Hafalan, Tulisan)
            var jenisPenilaian = $(this).text();
            var jadwalMahasiswaId = $(this).closest('tr').find('td').eq(0).text(); // Ambil btq jadwal mahasiswa id

            // Ubah judul modal sesuai jenis penilaian
            $('#modalPenilaianLabel').text('Penilaian ' + jenisPenilaian);

            // Tampilkan loading spinner
            $('#loadingSpinner').show();

            // AJAX request untuk mendapatkan data penilaian
            $.ajax({
                url: "{{ route('btq.penilaian.get') }}", // Sesuaikan route di backend
                type: 'GET',
                data: {
                    jadwal_mahasiswa_id: jadwalMahasiswaId,
                    jenis_penilaian: jenisPenilaian,
                    jadwal_id: "{{ $jadwal->id }}" // Kirim ID jadwal jika diperlukan
                },
                success: function(response) {
                    // Muat konten penilaian ke dalam tabel
                    var tbody = $('#tabelData tbody');
                    tbody.empty(); // Kosongkan tabel

                    $.each(response.penilaian, function(index, penilaian) {
                        tbody.append(`
                            <tr>
                            <td style="text-align: center;vertical-align: middle;">${penilaian.btq_penilaian.no_urut}</td>
                            <td>${penilaian.btq_penilaian.text_penilaian}</td>
                            <td style="text-align: center;vertical-align: middle;"><input type="checkbox" name="penilaian[]" value="${penilaian.id}" ${penilaian.nilai == 1 ? 'checked' : ''}></td>
                        </tr>
                    `);
                    });

                    // Sembunyikan loading spinner
                    $('#loadingSpinner').hide();

                    // Tampilkan modal
                    $('#modalPenilaian').modal('show');
                },
                error: function(xhr, status, error) {
                    // Tampilkan error jika terjadi masalah
                    Swal.fire(
                        'Gagal!',
                        'Tidak dapat memuat data penilaian ' + jenisPenilaian + '.',
                        'error'
                    );

                    // Sembunyikan loading spinner
                    $('#loadingSpinner').hide();
                }
            });
        });

        $('#btnSimpanPenilaian').on('click', function() {
            var dataPenilaian = [];
            $('#tabelData input[type="checkbox"]').each(function() {
                var penilaianId = $(this).val();
                var nilai = $(this).is(':checked') ? 1 : 0; // Nilai 1 jika dicentang, 0 jika tidak

                // Pastikan penilaianId tidak kosong
                if (penilaianId) {
                    dataPenilaian.push({
                        id: penilaianId, // ID valid
                        nilai: nilai // Nilai (1 untuk dicentang, 0 untuk tidak)
                    });
                }
            });

            // Kirim data penilaian yang dipilih ke backend
            $.ajax({
                url: "{{ route('btq.penilaian.save') }}", // Sesuaikan route untuk menyimpan data
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // Token CSRF untuk keamanan
                    penilaian: dataPenilaian,
                    penguji_id: "{{ Auth::user()->id }}"
                },
                success: function(response) {
                    Swal.fire(
                        'Berhasil!',
                        'Penilaian berhasil disimpan.',
                        'success'
                    ).then(() => {
                        // Tutup modal dan reload halaman setelah SweetAlert ditutup
                        $('#modalPenilaian').modal('hide');
                        location.reload(); // Reload halaman
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Gagal!',
                        'Tidak dapat menyimpan penilaian.',
                        'error'
                    );
                }
            });
        });
    </script>
@endsection
