<select id="programstudi" class="form-select" aria-label="Default select example" name="programstudi" required>
    {{-- @foreach ($unitkerja as $unit) --}}
    <option value="">Pilih Program Studi..</option>
    @if ($unitkerja->jenis_unit == 'FAKULTAS')
        <option value="{{ $unitkerja->id }}">
            {{ $unitkerja->nama_unit }}</option>

        @foreach ($unitkerja->childUnit as $child)
            <option value="S1 {{ $child->nama_unit }}">S1
                {{ $child->nama_unit }}</option>
        @endforeach
    @endif

    @if ($unitkerja->jenis_unit == 'Program Studi')
        <option value="S1{{ $unitkerja->nama_unit }}">
            S1 {{ $unitkerja->nama_unit }}</option>
    @endif
</select>
