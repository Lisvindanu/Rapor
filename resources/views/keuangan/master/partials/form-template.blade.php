{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\form-template.blade.php --}}
{{-- Clean form template untuk semua master data keuangan --}}

<div class="container">
    @include('keuangan.master.partials.header')
    @include('komponen.message-alert')
    @include('keuangan.master.partials.development-alert')

    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">{{ $headerConfig['title'] }}</h4>
                    <p class="text-muted mb-0">{{ $headerConfig['description'] }}</p>
                </div>
                <a href="{{ $headerConfig['back_route'] }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>{{ $headerConfig['back_text'] ?? 'Kembali' }}
                </a>
            </div>
        </div>
    </div>

    {{-- Form Section --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-{{ $formConfig['icon'] ?? 'edit' }} me-2 text-primary"></i>
                        {{ $formConfig['title'] }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ $formConfig['action'] }}" method="POST" id="masterForm">
                        @csrf
                        @if(isset($formConfig['method']) && $formConfig['method'] === 'PUT')
                            @method('PUT')
                        @endif

                        @foreach($formConfig['fields'] as $field)
                            <div class="row mb-3">
                                <div class="col-{{ $field['col_size'] ?? '12' }}">
                                    <label for="{{ $field['name'] }}" class="form-label">
                                        {{ $field['label'] }}
                                        @if($field['required'] ?? false)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @if($field['type'] === 'text')
                                        <input type="text"
                                               class="form-control @error($field['name']) is-invalid @enderror"
                                               id="{{ $field['name'] }}"
                                               name="{{ $field['name'] }}"
                                               value="{{ old($field['name'], data_get($formConfig['data'] ?? null, $field['name'])) }}"
                                               placeholder="{{ $field['placeholder'] ?? '' }}"
                                            {{ ($field['required'] ?? false) ? 'required' : '' }}>

                                    @elseif($field['type'] === 'date')
                                        <input type="date"
                                               class="form-control @error($field['name']) is-invalid @enderror"
                                               id="{{ $field['name'] }}"
                                               name="{{ $field['name'] }}"
                                               value="{{ old($field['name'], optional(data_get($formConfig['data'] ?? null, $field['name']))->format('Y-m-d')) }}"
                                            {{ ($field['required'] ?? false) ? 'required' : '' }}>

                                    @elseif($field['type'] === 'select')
                                        <select class="form-control @error($field['name']) is-invalid @enderror"
                                                id="{{ $field['name'] }}"
                                                name="{{ $field['name'] }}"
                                            {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            @if(isset($field['placeholder']))
                                                <option value="">{{ $field['placeholder'] }}</option>
                                            @endif
                                            @foreach($field['options'] ?? [] as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old($field['name'], data_get($formConfig['data'] ?? null, $field['name'])) == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>

                                    @elseif($field['type'] === 'textarea')
                                        <textarea class="form-control @error($field['name']) is-invalid @enderror"
                                                  id="{{ $field['name'] }}"
                                                  name="{{ $field['name'] }}"
                                                  rows="{{ $field['rows'] ?? 3 }}"
                                                  placeholder="{{ $field['placeholder'] ?? '' }}"
                                                  {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old($field['name'], data_get($formConfig['data'] ?? null, $field['name'])) }}</textarea>
                                    @endif

                                    @if(isset($field['help_text']))
                                        <div class="form-text">{{ $field['help_text'] }}</div>
                                    @endif

                                    @error($field['name'])
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        {{-- Global Error Messages --}}
                        @if($errors->has('overlap'))
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ $errors->first('overlap') }}
                            </div>
                        @endif

                        {{-- Submit Buttons --}}
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ $formConfig['cancel_route'] }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>{{ $formConfig['submit_text'] ?? 'Simpan' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Panel --}}
        @if(isset($formConfig['info_panel']))
            <div class="col-lg-4">
                <div class="card border-{{ $formConfig['info_panel']['type'] ?? 'info' }}">
                    <div class="card-header bg-{{ $formConfig['info_panel']['type'] ?? 'info' }} text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-{{ $formConfig['info_panel']['icon'] ?? 'info-circle' }} me-2"></i>
                            {{ $formConfig['info_panel']['title'] }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <h6 class="text-{{ $formConfig['info_panel']['type'] ?? 'info' }}">{{ $formConfig['info_panel']['subtitle'] ?? 'Informasi:' }}</h6>
                        <ul class="list-unstyled small">
                            @foreach($formConfig['info_panel']['items'] ?? [] as $item)
                                <li class="mb-2">
                                    <i class="fas fa-{{ $item['icon'] ?? 'check' }} text-{{ $item['color'] ?? 'success' }} me-2"></i>
                                    {!! $item['text'] !!}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        // Date validation untuk tahun anggaran
        @if(in_array('tgl_awal_anggaran', collect($formConfig['fields'] ?? [])->pluck('name')->toArray()))
        document.getElementById('tgl_awal_anggaran')?.addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('tgl_akhir_anggaran');

            if (startDate && endDateInput) {
                endDateInput.min = startDate;

                if (endDateInput.value && endDateInput.value < startDate) {
                    endDateInput.value = '';
                }
            }
        });

        // Set initial min date
        const startDate = document.getElementById('tgl_awal_anggaran')?.value;
        if (startDate) {
            const endDateInput = document.getElementById('tgl_akhir_anggaran');
            if (endDateInput) endDateInput.min = startDate;
        }
        @endif

        console.log('✅ Clean form template loaded');
    </script>
@endpush
