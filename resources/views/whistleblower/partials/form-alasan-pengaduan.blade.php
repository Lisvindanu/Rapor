{{-- resources/views/whistleblower/partials/form-alasan-pengaduan.blade.php --}}
<div class="mb-4">
    <h6 class="border-bottom pb-2 mb-3">Alasan Pengaduan</h6>
    
    <div class="alasan-pengaduan-section border rounded p-3">
        <p class="mb-3"><strong>Alasan pengaduan (Silakan centang satu atau lebih pilihan berikut):</strong> <span class="text-danger">*</span></p>
        
        <div class="row">
            @php
                $alasan_options = [
                    'kekerasan_seksual' => 'Kekerasan Seksual',
                    'diskriminasi_gender' => 'Diskriminasi berdasarkan Gender',
                    'diskriminasi_ras' => 'Diskriminasi berdasarkan Ras/Suku',
                    'diskriminasi_agama' => 'Diskriminasi berdasarkan Agama',
                    'diskriminasi_disabilitas' => 'Diskriminasi berdasarkan Disabilitas',
                    'perundungan' => 'Perundungan (Bullying)',
                    'pelecehan_verbal' => 'Pelecehan Verbal',
                    'pelecehan_fisik' => 'Pelecehan Fisik',
                    'penyalahgunaan_kekuasaan' => 'Penyalahgunaan Kekuasaan',
                    'lainnya' => 'Lainnya'
                ];
                $old_alasan = old('alasan_pengaduan', []);
            @endphp
            
            @foreach($alasan_options as $value => $label)
                <div class="col-md-6 mb-2">
                    <div class="form-check">
                        <input class="form-check-input @error('alasan_pengaduan') is-invalid @enderror" 
                               type="checkbox" 
                               name="alasan_pengaduan[]" 
                               value="{{ $value }}" 
                               id="alasan_{{ $value }}"
                               {{ in_array($value, $old_alasan) ? 'checked' : '' }}>
                        <label class="form-check-label" for="alasan_{{ $value }}">
                            {{ $label }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        
        @error('alasan_pengaduan')
            <div class="text-danger mt-2">
                <small>{{ $message }}</small>
            </div>
        @enderror
    </div>
</div>