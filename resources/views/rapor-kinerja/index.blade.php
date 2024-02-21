@extends('layouts.main')

@section('css-tambahan')
    <style>
        /* Style untuk menunjukkan elemen sedang diedit */
        .nama-dosen-col {
            width: 200px;
            /* Atur lebar sesuai kebutuhan Anda */
        }

        .table {
            text-align: center;
            /* Posisikan teks judul tengah */
        }

        .table th,
        .table td {
            border: 1px solid #000;
            /* Berikan garis border */
            padding: 8px;
            /* Atur padding agar konten terlihat lebih rapi */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
            /* Posisikan tabel ke tengah */
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            /* Garis border dengan warna abu-abu muda */
            padding: 10px;
            /* Padding untuk ruang antara konten dan tepi sel */
        }

        .table th {
            background-color: #f2f2f2;
            /* Warna latar belakang untuk judul */
            font-weight: bold;
            /* Teks judul lebih tebal */
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
            /* Warna latar belakang untuk baris genap */
        }

        .table tbody tr:hover {
            background-color: #f2f2f2;
            /* Warna latar belakang saat baris dihover */
        }

        .table-container {
            max-height: 400px;
            /* Atur tinggi maksimum kontainer */
            overflow: auto;
            /* Tambahkan scrollbar jika konten melebihi tinggi maksimum */
        }
    </style>
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-11">
                <div class="judul-modul">
                    <h3>Beranda</h3>
                </div>
            </div>
        </div>

        <div class="filter-konten">
            <div class="row justify-content-md-center">
                <div class="col-11">
                    <div class="card">
                        <div class="card-body" style="display: flex;">
                            <div class="col-6" style="padding: 10px">
                                <div class="form-label">
                                    <label>
                                        <p> <strong>Periode
                                            </strong></p>
                                    </label>
                                </div>
                                <div class="filter">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Pilih Unit Kerja</option>
                                        {{-- <option value="1">Unsur BKD Sister</option>
                                        <option value="2">EDOM</option>
                                        <option value="3">EDASEP</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-6" style="padding: 10px">
                                <div class="form-label">
                                    <label>
                                        <p> <strong>Unit Kerja</strong></p>
                                    </label>
                                </div>
                                <div class="filter">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Pilih Unit Kerja</option>
                                        {{-- <option value="1">Unsur BKD Sister</option>
                                        <option value="2">EDOM</option>
                                        <option value="3">EDASEP</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="isi-konten">
            <div class="row justify-content-md-center">
                <div class="col-11">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff">
                            <div class="row">
                                <div class="col-6">
                                    {{-- <h5>Indikator Kinerja</h5> --}}
                                </div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        <a href="{{ route('indikator-kinerja') }}" class="btn btn-info"
                                            style="color:#fff">Generate Data</a>

                                        <button class="btn btn-success" type="submit" form="form-indikator">Upload
                                            Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="table-container">
                                    <table class="table table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th rowspan="2">NIP</th>
                                                <th rowspan="2" class="nama-dosen-col">Nama Dosen</th>
                                                <th colspan="5">Unsur BKD Sister</th>
                                                <th colspan="4">EDOM</th>
                                                <th colspan="3">EDASEP</th>
                                                <th rowspan="2">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th>Pendidikan</th>
                                                <th>Penelitian</th>
                                                <th>PPM</th>
                                                <th>Penunjangan</th>
                                                <th>Kewajiban Khusus</th>
                                                <th>Materi Pembelajaran</th>
                                                <th>Pengelolaan Kelas</th>
                                                <th>Proses Pengajaran</th>
                                                <th>Penilaian</th>
                                                <th>Atasan</th>
                                                <th>Sejawat</th>
                                                <th>Bawahan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>IF397</td>
                                                <td>Moch. Ilham Anugrah S.T., M.Sc.Eng</td>
                                                <td>M</td>
                                                <td>M</td>
                                                <td>M</td>
                                                <td>M</td>
                                                <td>M</td>
                                                <td>3.00</td>
                                                <td>3.00</td>
                                                <td>3.00</td>
                                                <td>3.00</td>
                                                <td>80</td>
                                                <td>80</td>
                                                <td>80</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger delete">
                                                        <i class="fas fa-trash-alt fa-xs"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-primary save">
                                                        <i class="fas fa-save fa-xs"></i>
                                                    </button>
                                                    <a href="#" class="btn btn-sm btn-info detail">
                                                        <i class="fas fa-link fa-xs"></i>
                                                    </a>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        $(document).ready(function() {
            // Simpan data setelah mengedit
            $('#editableTable').on('click', '.save', function() {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text();
                var nama_indikator_kinerja = row.find('td:eq(2)').text();
                var bobot = row.find('td:eq(3)').text();
                var urutan = row.find('td:eq(4)').text();
                var type_indikator = row.find('td:eq(5)').text();

                $.ajax({
                    type: "PUT",
                    url: "/rapor/indikator-kinerja/" + id,
                    data: {
                        nama_indikator_kinerja: nama_indikator_kinerja,
                        bobot: bobot,
                        urutan: urutan,
                        type_indikator: type_indikator,
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT'
                    },
                    success: function(response) {
                        alert('Data berhasil diupdate');
                        // Lakukan sesuatu setelah data berhasil diupdate
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                });
            });

            // Hapus baris tabel
            $('#editableTable').on('click', '.delete', function() {
                if (confirm('Apakah Anda yakin ingin menghapus baris ini?')) {
                    var row = $(this).closest('tr');
                    var id = row.find('td:eq(0)').text(); // Ambil id data yang akan dihapus

                    // Kirim permintaan penghapusan ke server menggunakan Ajax
                    $.ajax({
                        type: "DELETE",
                        url: "/rapor/indikator-kinerja/" + id,
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            alert('Data berhasil dihapus');
                            row.remove(); // Hapus baris dari tabel setelah berhasil dihapus
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert('Terjadi kesalahan, silakan coba lagi.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
