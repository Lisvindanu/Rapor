@extends('layouts.main2')

@section('css-tambahan')
@endsection

@section('navbar')
    @include('kuesioner.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Bank Soal</h3>
                        <p>Daftar Soal</p>
                    </span>
                </div>
            </div>
        </div>

        {{-- tampilkan message session success/error jika ada --}}
        @if (session('message'))
            <div class="isi-konten">
                <div class="row justify-content-md-center">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="isi-konten" style="margin-top: 0px;">
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="query" id="querySearch" class="form-control"
                                                placeholder="Cari berdasarkan Nama Soal">
                                            <button id="btn-cari-search" type="button"
                                                class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-6">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end"">
                                        {{-- <a href="{{ route('indikator-kinerja') }}" class="btn btn-info"
                                            style="color:#fff">Generate Data</a> --}}
                                        {{-- button tambah --}}
                                        {{-- <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                            data-bs-target="#uploadModal">
                                            Unggah Data
                                        </button> --}}
                                        <a href="{{ route('kuesioner.banksoal.create') }}" class="btn btn-primary"
                                            style="color:#fff">Tambah
                                            Soal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: flex">
                            <div class="col-md-12">
                                <div class="table-container">
                                    <table class="table table-hover" id="editableTable">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Nama Soal
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Keterangan
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">Jml. Soal</th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Waktu Pembuatan</th>

                                                <th style="text-align: center;vertical-align: middle;">
                                                    Publik
                                                </th>
                                                <th style="text-align: center;vertical-align: middle;">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-body">
                                            {{-- foreach untuk data rapor --}}
                                            @if (count($data) == 0)
                                                <tr>
                                                    <td colspan="6">Tidak ada data</td>
                                                </tr>
                                            @else
                                                @foreach ($data as $soal)
                                                    <tr style="text-align: center;vertical-align: middle;">
                                                        <td hidden>{{ $soal->id }}</td>
                                                        <td>{{ $soal->nama_soal }}</td>
                                                        <td>{{ $soal->keterangan }}</td>
                                                        <td>{{ $soal->jumlah_pertanyaan }}</td>
                                                        <td>{{ $soal->created_at }}</td>
                                                        <td>
                                                            @if ($soal->publik == 1)
                                                                <i class="fas fa-check-circle" style="color: green"></i>
                                                            @else
                                                                <i class="fas fa-times-circle" style="color: red"></i>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('kuesioner.banksoal.show', ['id' => $soal->id]) }}"
                                                                class="btn btn-sm btn-info detail">
                                                                <i class="fas fa-link fa-xs"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-warning edit">
                                                                <i class="fas fa-edit fa-xs"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-danger delete">
                                                                <i class="fas fa-trash-alt fa-xs"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Tambahkan container untuk pagination di bawah tabel -->
                                <div id="data-info">
                                    Total data: <span id="total-data">{{ $total }}</span>
                                </div>
                                <div id="pagination-container" class="mt-3">

                                    <!-- Tempat untuk menampilkan pagination links -->
                                    <!-- Bagian tombol pagination pada tabel -->
                                    <ul class="pagination justify-content-center">
                                        <!-- Tombol Previous -->
                                        <li class="page-item {{ $data->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a href="{{ $data->url(1) }}" class="page-link">Previous</a>
                                        </li>

                                        <!-- Nomor Halaman -->
                                        @for ($i = 1; $i <= $data->lastPage(); $i++)
                                            <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                                                <a href="{{ $data->url($i) }}" class="page-link">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        <!-- Tombol Next -->
                                        <li
                                            class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }}">
                                            <a href="{{ $data->url($data->currentPage() + 1) }}" class="page-link">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Unggah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengunggah file -->
                            <form id="uploadForm" action="{{ url('/rapor/import-rapor-kinerja') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="form-label">Pilih File:</label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>
                                {{-- <div class="mb-3">
                                    <button type="button" class="btn btn-success" id="exportExcelModalBtn">Export to
                                        Excel</button>
                                </div> --}}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" id="btn-template-dokumen"
                                        style="color: white">Template
                                        Dokumen</button>

                                    <button type="submit" class="btn btn-primary">Unggah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js-tambahan')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        const btnCari2 = document.querySelector("#btn-cari-search");

        btnCari2.addEventListener("click", function() {
            searchData(1); // Memanggil searchData dengan parameter 1 untuk halaman pertama
        });

        function searchData(page) {
            const query = document.querySelector("input[name='query']").value;

            // Kirim permintaan AJAX ke server dengan opsi yang dipilih
            $.ajax({
                url: "{{ url('api/rapor/rapor-kinerja') }}",
                method: "GET",
                data: {
                    search: query,
                    page: page // Mengirimkan parameter page
                },
                success: function(response) {
                    updateTable(response);
                    updatePagination(response); // Memanggil fungsi updatePagination dengan response
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Terjadi kesalahan, silakan coba lagi.");
                }
            });
        }

        function updateTable(response) {
            const tableBody = document.querySelector("#tabel-body");
            tableBody.innerHTML = "";

            const dataRapor = response.data;

            if (dataRapor.length === 0) {
                const emptyRow = document.createElement("tr");
                emptyRow.innerHTML = `
                <td colspan="6" class="text-center">No data available</td>
            `;
                tableBody.appendChild(emptyRow);
                return;
            }

            dataRapor.forEach(function(rapor) {
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                <td>${rapor.dosen_nip}</td>
                <td>${rapor.dosen.nama}</td>
                <td>${rapor.bkd_total}</td>
                <td>${rapor.edom_materipembelajaran}</td>
                <td>${rapor.edom_pengelolaankelas}</td>
                <td>${rapor.edom_prosespengajaran}</td>
                <td>${rapor.edom_penilaian}</td>
                <td>${rapor.edasep_atasan}</td>
                <td>${rapor.edasep_sejawat}</td>
                <td>${rapor.edasep_bawahan}</td>
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
                </td>
            `;

                tableBody.appendChild(newRow);
            });
        }
        // Script untuk pagination
        function updatePagination(response) {
            const paginationContainer = document.querySelector("#pagination-container");
            paginationContainer.innerHTML = '';

            const totalPages = response.last_page;
            const currentPage = response.current_page;
            const totalData = response.total; // Menambah total data dari respons

            let paginationHTML = '';

            if (totalPages > 1) {
                paginationHTML += `
            <ul class="pagination justify-content-center">
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="fetchData(${currentPage - 1})">Previous</a>
                </li>`;

                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `
                <li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="fetchData(${i})">${i}</a>
                </li>`;
                }

                paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="fetchData(${currentPage + 1})">Next</a>
            </li>
        </ul>`;
            }
            paginationContainer.innerHTML = paginationHTML;

            // Menampilkan total data
            const totalDataElement = document.querySelector("#total-data");
            totalDataElement.textContent = totalData;
        }
    </script>
@endsection
