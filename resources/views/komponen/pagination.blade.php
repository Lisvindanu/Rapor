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
            <a href="{{ $data->url(max(1, $data->currentPage() - 1)) }}" class="page-link">Previous</a>
        </li>

        <!-- Nomor Halaman -->
        @php
            $startPage = max(1, min($data->lastPage() - 9, $data->currentPage() - 4));
            $endPage = min($startPage + 9, $data->lastPage());
        @endphp
        @for ($i = $startPage; $i <= $endPage; $i++)
            <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                <a href="{{ $data->url($i) }}" class="page-link">{{ $i }}</a>
            </li>
        @endfor

        <!-- Tombol Next -->
        <li class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }}">
            <a href="{{ $data->url(min($data->lastPage(), $data->currentPage() + 1)) }}" class="page-link">Next</a>
        </li>
    </ul>
</div>
