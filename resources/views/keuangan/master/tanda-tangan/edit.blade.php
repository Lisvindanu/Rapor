{{-- resources/views/keuangan/master/tanda-tangan/edit.blade.php --}}
@extends('keuangan.master.layouts.master-edit')

@php
    $headerConfig = [
        'title' => 'Edit Penanda Tangan',
        'description' => 'Mengubah data penanda tangan: ' . $tandaTangan->nama,
        'back_route' => route('keuangan.tanda-tangan.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Edit Penanda Tangan',
        'action' => route('keuangan.tanda-tangan.update', $tandaTangan->id),
        'cancel_route' => route('keuangan.tanda-tangan.index'),
        'data' => $tandaTangan,
        'fields' => [
            [
                'name' => 'nomor_ttd',
                'label' => 'Nomor TTD',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Contoh: TTD-001',
                'col_size' => '6',
                'help_text' => 'Nomor unik untuk identifikasi tanda tangan'
            ],
            [
                'name' => 'nama',
                'label' => 'Nama Lengkap',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Masukkan nama lengkap',
                'col_size' => '6'
            ],
            [
                'name' => 'jabatan',
                'label' => 'Jabatan',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Masukkan jabatan',
                'col_size' => '12'
            ],
            [
                'name' => 'gambar_ttd',
                'label' => 'Gambar Tanda Tangan',
                'type' => 'tanda_tangan',
                'required' => false,
                'col_size' => '12',
                'help_text' => 'Kosongkan jika tidak ingin mengubah tanda tangan'
            ]
        ]
    ];
@endphp

@section('css-tambahan')
    @parent
    <style>
        .signature-pad-container {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .signature-pad-container:hover {
            border-color: #007bff;
            background-color: #e7f3ff;
        }

        .signature-canvas {
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
            cursor: crosshair;
        }

        .signature-controls {
            margin-top: 15px;
        }

        .signature-controls .btn {
            margin: 0 5px;
        }

        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: #007bff;
            background-color: #e7f3ff;
        }

        .signature-preview {
            max-width: 200px;
            max-height: 100px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-top: 10px;
        }

        .tab-content {
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 4px 4px;
            padding: 20px;
        }

        .current-signature {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }

        .current-signature img {
            max-width: 200px;
            max-height: 100px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background-color: white;
        }
    </style>
@endsection

@section('js-tambahan')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentSignature = @json($tandaTangan->image_preview);
            if (currentSignature) {
                const currentImg = document.getElementById('current-signature-img');
                if (currentImg) {
                    currentImg.src = currentSignature;
                    currentImg.style.display = 'block';
                }
            }

            const canvas = document.getElementById('signature-canvas');
            const ctx = canvas.getContext('2d');
            const clearBtn = document.getElementById('clear-signature');
            const signatureInput = document.getElementById('gambar_ttd');

            let isDrawing = false;

            canvas.width = 400;
            canvas.height = 200;

            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);

            canvas.addEventListener('touchstart', handleTouch);
            canvas.addEventListener('touchmove', handleTouch);
            canvas.addEventListener('touchend', stopDrawing);

            function startDrawing(e) {
                isDrawing = true;
                draw(e);
            }

            function draw(e) {
                if (!isDrawing) return;

                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.strokeStyle = '#000';

                ctx.lineTo(x, y);
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(x, y);
            }

            function stopDrawing() {
                if (isDrawing) {
                    isDrawing = false;
                    ctx.beginPath();
                    const dataURL = canvas.toDataURL();
                    signatureInput.value = dataURL;
                }
            }

            function handleTouch(e) {
                e.preventDefault();
                const touch = e.touches[0];
                const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' :
                    e.type === 'touchmove' ? 'mousemove' : 'mouseup', {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }

            clearBtn.addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                signatureInput.value = '';
            });

            const fileInput = document.getElementById('signature-file');
            const uploadArea = document.getElementById('upload-area');
            const preview = document.getElementById('signature-preview');

            uploadArea.addEventListener('click', () => fileInput.click());

            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#007bff';
                this.style.backgroundColor = '#e7f3ff';
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#dee2e6';
                this.style.backgroundColor = '#f8f9fa';
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#dee2e6';
                this.style.backgroundColor = '#f8f9fa';

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFileSelect(files[0]);
                }
            });

            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    handleFileSelect(e.target.files[0]);
                }
            });

            function handleFileSelect(file) {
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file.');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('File size should be less than 2MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const maxWidth = 400;
                        const maxHeight = 200;
                        let { width, height } = img;

                        if (width > maxWidth || height > maxHeight) {
                            const ratio = Math.min(maxWidth / width, maxHeight / height);
                            width *= ratio;
                            height *= ratio;
                        }

                        const tempCanvas = document.createElement('canvas');
                        const tempCtx = tempCanvas.getContext('2d');
                        tempCanvas.width = width;
                        tempCanvas.height = height;
                        tempCtx.drawImage(img, 0, 0, width, height);

                        const dataURL = tempCanvas.toDataURL();
                        signatureInput.value = dataURL;

                        preview.src = dataURL;
                        preview.style.display = 'block';
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }

            const form = document.getElementById('masterForm');
            form.addEventListener('submit', function(e) {
                const nomorTtd = document.getElementById('nomor_ttd').value.trim();
                const nama = document.getElementById('nama').value.trim();
                const jabatan = document.getElementById('jabatan').value.trim();

                if (!nomorTtd || !nama || !jabatan) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return false;
                }
            });
        });
    </script>
@endsection
