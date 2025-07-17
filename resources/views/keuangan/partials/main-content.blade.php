{{-- Main Content Area --}}
<div class="isi-konten">
    <div class="row">
        {{-- Quick Actions Card --}}
        <div class="col-6">
            @include('keuangan.partials.quick-actions')
        </div>

        {{-- Categories Card --}}
        <div class="col-6">
            @include('keuangan.partials.categories')
        </div>
    </div>

    {{-- Transactions Preview Table --}}
    <div class="row mt-3">
        <div class="col-12">
            @include('keuangan.partials.transactions-table')
        </div>
    </div>
</div>
