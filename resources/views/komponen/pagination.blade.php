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
        <li class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }}">
            <a href="{{ $data->url($data->currentPage() + 1) }}" class="page-link">Next</a>
        </li>
    </ul>
</div>
