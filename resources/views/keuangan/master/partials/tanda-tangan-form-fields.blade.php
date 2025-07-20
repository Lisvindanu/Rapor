{{-- resources/views/keuangan/master/partials/tanda-tangan-form-fields.blade.php --}}

@if($field['type'] === 'tanda_tangan')
    <div class="col-{{ $field['col_size'] ?? '12' }}">
        <label for="{{ $field['name'] }}" class="form-label">
            {{ $field['label'] }}
            @if($field['required'] ?? false)
                <span class="text-danger">*</span>
            @endif
        </label>

        @if(isset($formConfig['data']) && $formConfig['data']->has_image ?? false)
            <div class="current-signature mb-3">
                <h6 class="text-muted mb-2">
                    <i class="fas fa-signature me-1"></i>Tanda Tangan Saat Ini:
                </h6>
                <img id="current-signature-img"
                     src="{{ $formConfig['data']->image_preview ?? '' }}"
                     alt="Current Signature"
                     class="signature-preview"
                     style="display: {{ isset($formConfig['data']) && $formConfig['data']->has_image ? 'block' : 'none' }};">
                <p class="text-muted mt-2 mb-0">
                    <small>Buat tanda tangan baru di bawah untuk mengubah tanda tangan yang ada</small>
                </p>
            </div>
        @endif

        <ul class="nav nav-tabs" id="signatureTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="draw-tab" data-bs-toggle="tab"
                        data-bs-target="#draw-pane" type="button" role="tab">
                    <i class="fas fa-pencil-alt me-1"></i>Gambar Manual
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="upload-tab" data-bs-toggle="tab"
                        data-bs-target="#upload-pane" type="button" role="tab">
                    <i class="fas fa-upload me-1"></i>Upload File
                </button>
            </li>
        </ul>

        <div class="tab-content" id="signatureTabContent">
            <div class="tab-pane fade show active" id="draw-pane" role="tabpanel">
                <div class="signature-pad-container">
                    <h6 class="mb-3">
                        <i class="fas fa-pencil-alt me-1"></i>Gambar Tanda Tangan
                    </h6>
                    <canvas id="signature-canvas" class="signature-canvas"></canvas>
                    <div class="signature-controls">
                        <button type="button" id="clear-signature" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-eraser me-1"></i>Hapus
                        </button>
                        <small class="text-muted ms-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Gunakan mouse atau touch untuk menggambar tanda tangan
                        </small>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="upload-pane" role="tabpanel">
                <div id="upload-area" class="file-upload-area">
                    <div class="mb-3">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h6>Drag & Drop atau Klik untuk Upload</h6>
                        <p class="text-muted mb-0">
                            Format yang didukung: PNG, JPG, JPEG<br>
                            Maksimal ukuran file: 2MB
                        </p>
                    </div>
                    <input type="file" id="signature-file" class="d-none" accept="image/*">
                </div>
                <img id="signature-preview" class="signature-preview" style="display: none;" alt="Preview">
            </div>
        </div>

        <input type="hidden"
               id="{{ $field['name'] }}"
               name="{{ $field['name'] }}"
               value="{{ old($field['name'], data_get($formConfig['data'] ?? null, $field['name'])) }}">

        @if(isset($field['help_text']))
            <div class="form-text">
                <i class="fas fa-info-circle me-1"></i>{{ $field['help_text'] }}
            </div>
        @endif

        @error($field['name'])
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
@endif
