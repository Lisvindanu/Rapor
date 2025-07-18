{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\action-buttons.blade.php --}}
@if(isset($actionConfig) && isset($actionConfig['buttons']))
    <div class="row justify-content-md-center">
        <div class="container">
            <div class="card">
                <div class="card-header" style="background-color: #fff; margin-top:10px">
                    <h5 class="card-title">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group-master d-flex flex-wrap gap-2">
                        @foreach($actionConfig['buttons'] as $button)
                            @if(isset($button['type']) && $button['type'] === 'delete')
                                <form action="{{ $button['route'] }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('{{ $button['confirm_message'] ?? 'Yakin ingin menghapus data ini?' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn {{ $button['class'] ?? 'btn-danger' }}">
                                        @if(isset($button['icon']))
                                            <i class="{{ $button['icon'] }} me-1"></i>
                                        @endif
                                        {{ $button['text'] ?? 'Hapus' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ $button['route'] }}" class="btn {{ $button['class'] ?? 'btn-primary' }}">
                                    @if(isset($button['icon']))
                                        <i class="{{ $button['icon'] }} me-1"></i>
                                    @endif
                                    {{ $button['text'] ?? 'Aksi' }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    .btn-group-master .btn {
        min-width: 120px;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 576px) {
        .btn-group-master {
            flex-direction: column;
        }

        .btn-group-master .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>
