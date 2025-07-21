{{-- resources/views/whistleblower/partials/form-persetujuan.blade.php --}}
<div class="mb-4">
    <h6 class="border-bottom pb-2 mb-3">Persetujuan & Kebijakan</h6>
    
    <div class="border rounded p-3">
        <div class="form-check">
            <input class="form-check-input @error('persetujuan_kebijakan') is-invalid @enderror" 
                   type="checkbox" id="persetujuan_kebijakan" name="persetujuan_kebijakan" 
                   value="1" required {{ old('persetujuan_kebijakan') ? 'checked' : '' }}>
            <label class="form-check-label" for="persetujuan_kebijakan">
                Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#kebijakanModal">kebijakan privasi</a> 
                dan memahami bahwa informasi yang saya berikan akan diproses sesuai dengan prosedur PPKPT 
                <span class="text-danger">*</span>
            </label>
            @error('persetujuan_kebijakan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-3">
            <div class="alert alert-info">
                <i class="fas fa-shield-alt"></i>
                <strong>Jaminan Kerahasiaan:</strong>
                <ul class="mt-2 mb-0">
                    <li>Identitas pelapor akan dijaga kerahasiaannya</li>
                    <li>Laporan akan ditangani oleh tim profesional PPKPT</li>
                    <li>Tidak ada retaliasi terhadap pelapor yang beritikad baik</li>
                    <li>Proses penanganan mengikuti standar operasional yang berlaku</li>
                </ul>
            </div>
        </div>
    </div>
</div>