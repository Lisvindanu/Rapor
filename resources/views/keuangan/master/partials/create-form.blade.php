{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\create-form.blade.php --}}
@if(isset($formConfig))
    <div class="row justify-content-md-center">
        <div class="container">
            <div class="card">
                <div class="card-header" style="background-color: #fff; margin-top:10px">
                    <h5 class="card-title">{{ $formConfig['title'] ?? 'Tambah Data' }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ $formConfig['action'] }}" method="POST" id="masterCreateForm">
                        @csrf
                        <div class="row">
                            @foreach($formConfig['fields'] as $field)
                                <div class="col-md-{{ $field['col_size'] ?? '6' }}">
                                    <div class="form-group mb-3">
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
                                                   value="{{ old($field['name'], '') }}"
                                                   placeholder="{{ $field['placeholder'] ?? '' }}"
                                                   autocomplete="off"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>

                                        @elseif($field['type'] === 'email')
                                            <input type="email"
                                                   class="form-control @error($field['name']) is-invalid @enderror"
                                                   id="{{ $field['name'] }}"
                                                   name="{{ $field['name'] }}"
                                                   value="{{ old($field['name'], '') }}"
                                                   placeholder="{{ $field['placeholder'] ?? '' }}"
                                                   autocomplete="off"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>

                                        @elseif($field['type'] === 'number')
                                            <input type="number"
                                                   class="form-control @error($field['name']) is-invalid @enderror"
                                                   id="{{ $field['name'] }}"
                                                   name="{{ $field['name'] }}"
                                                   value="{{ old($field['name'], '') }}"
                                                   placeholder="{{ $field['placeholder'] ?? '' }}"
                                                   min="{{ $field['min'] ?? '' }}"
                                                   max="{{ $field['max'] ?? '' }}"
                                                   step="{{ $field['step'] ?? '' }}"
                                                   autocomplete="off"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>

                                        @elseif($field['type'] === 'textarea')
                                            <textarea class="form-control @error($field['name']) is-invalid @enderror"
                                                      id="{{ $field['name'] }}"
                                                      name="{{ $field['name'] }}"
                                                      rows="{{ $field['rows'] ?? '3' }}"
                                                      placeholder="{{ $field['placeholder'] ?? '' }}"
                                                  {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old($field['name'], '') }}</textarea>

                                        @elseif($field['type'] === 'select')
                                            <select class="form-control @error($field['name']) is-invalid @enderror"
                                                    id="{{ $field['name'] }}"
                                                    name="{{ $field['name'] }}"
                                                {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                <option value="">{{ $field['placeholder'] ?? 'Pilih ' . $field['label'] }}</option>
                                                @foreach($field['options'] as $value => $label)
                                                    <option value="{{ $value }}" {{ old($field['name']) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        @elseif($field['type'] === 'checkbox')
                                            <div class="form-check">
                                                <input class="form-check-input @error($field['name']) is-invalid @enderror"
                                                       type="checkbox"
                                                       id="{{ $field['name'] }}"
                                                       name="{{ $field['name'] }}"
                                                       value="1"
                                                    {{ old($field['name']) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $field['name'] }}">
                                                    {{ $field['checkbox_label'] ?? $field['label'] }}
                                                </label>
                                            </div>

                                        @elseif($field['type'] === 'currency')
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number"
                                                       class="form-control @error($field['name']) is-invalid @enderror"
                                                       id="{{ $field['name'] }}"
                                                       name="{{ $field['name'] }}"
                                                       value="{{ old($field['name'], '0') }}"
                                                       placeholder="{{ $field['placeholder'] ?? '0' }}"
                                                       min="0"
                                                       step="0.01"
                                                       autocomplete="off"
                                                    {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                            </div>
                                        @endif

                                        @error($field['name'])
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        @if(isset($field['help_text']))
                                            <small class="form-text text-muted">{{ $field['help_text'] }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Form Actions --}}
                        <div class="btn-group-master mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ $formConfig['cancel_route'] ?? '#' }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
