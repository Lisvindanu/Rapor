{{-- F:\rapor-dosen\resources\views\keuangan\master\mata-anggaran\partials\header.blade.php --}}

@if(isset($headerConfig))
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            {{-- Judul dan Deskripsi --}}
            <div class="judul-modul d-flex align-items-center">
                @if(isset($headerConfig['icon']))
                    <i class="{{ $headerConfig['icon'] }} fa-2x me-3 text-primary"></i>
                @endif
                <div>
                    <h3 class="mb-0">{{ $headerConfig['title'] ?? 'Judul Halaman' }}</h3>
                    @if(isset($headerConfig['description']))
                        <p class="text-muted mb-0">{{ $headerConfig['description'] }}</p>
                    @endif
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex align-items-center">
                @if(isset($headerConfig['back_route']))
                    <a href="{{ $headerConfig['back_route'] }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>
                        {{ $headerConfig['back_text'] ?? 'Kembali' }}
                    </a>
                @endif
                @if(isset($headerConfig['primary_action']) && isset($headerConfig['primary_action']['route']))
                    <a href="{{ $headerConfig['primary_action']['route'] }}" class="btn {{ $headerConfig['primary_action']['class'] ?? 'btn-primary' }}">
                        @if(isset($headerConfig['primary_action']['icon']))
                            <i class="{{ $headerConfig['primary_action']['icon'] }} me-1"></i>
                        @endif
                        {{ $headerConfig['primary_action']['text'] ?? 'Aksi Utama' }}
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
