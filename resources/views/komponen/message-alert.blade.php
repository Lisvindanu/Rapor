{{--@if (session('message'))--}}
{{--    <div class="isi-konten">--}}
{{--        <div class="row justify-content-md-center">--}}
{{--            <div class="col-12">--}}
{{--                <div class="alert alert-success alert-dismissible fade show" role="alert">--}}
{{--                    {{ session('message') }}--}}

{{--                    --}}{{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, assumenda. --}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}


@if (session('message'))
    <div class="isi-konten">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="isi-konten">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session('warning'))
    <div class="isi-konten">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session('info'))
    <div class="isi-konten">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="isi-konten">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif
