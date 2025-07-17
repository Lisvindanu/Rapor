<div class="card">
    <div class="card-header" style="background-color: #fff; margin-top:10px">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title">Kategori Transaksi</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="list-group">
            @if(isset($kategoriStats) && count($kategoriStats) > 0)
                @foreach($kategoriStats as $kategori)
                    <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-item"
                            onclick="handleCategoryClick('{{ $kategori['nama'] }}', {{ $kategori['count'] }})"
                            data-category="{{ strtolower(str_replace(' ', '-', $kategori['nama'])) }}">
                        <span>
                            <i class="fas fa-{{ $kategori['icon'] }} text-{{ $kategori['icon_class'] }} me-2"></i>
                            {{ $kategori['nama'] }}
                        </span>
                        <span class="badge bg-{{ $kategori['icon_class'] }} rounded-pill">{{ $kategori['count'] }}</span>
                    </button>
                @endforeach
            @else
                {{-- Default categories when no data from controller --}}
                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-item"
                        onclick="handleCategoryClick('Pembayaran Tugas Akhir', 12)"
                        data-category="pembayaran-tugas-akhir">
                    <span><i class="fas fa-graduation-cap text-primary me-2"></i> Pembayaran Tugas Akhir</span>
                    <span class="badge bg-primary rounded-pill">12</span>
                </button>
                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-item"
                        onclick="handleCategoryClick('Honor Koreksi', 8)"
                        data-category="honor-koreksi">
                    <span><i class="fas fa-edit text-success me-2"></i> Honor Koreksi</span>
                    <span class="badge bg-success rounded-pill">8</span>
                </button>
                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-item"
                        onclick="handleCategoryClick('Pengeluaran Fakultas', 5)"
                        data-category="pengeluaran-fakultas">
                    <span><i class="fas fa-university text-warning me-2"></i> Pengeluaran Fakultas</span>
                    <span class="badge bg-warning rounded-pill">5</span>
                </button>
                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-item"
                        onclick="handleCategoryClick('Honor & Vakasi', 15)"
                        data-category="honor-vakasi">
                    <span><i class="fas fa-money-bill text-info me-2"></i> Honor & Vakasi</span>
                    <span class="badge bg-info rounded-pill">15</span>
                </button>
            @endif
        </div>
    </div>
</div>
