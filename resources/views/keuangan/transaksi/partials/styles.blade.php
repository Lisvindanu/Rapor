{{-- resources/views/keuangan/transaksi/partials/styles.blade.php --}}
<style>
    /* Basic card styling */
    .card {
        border: 1px solid #e3e6f0;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.375rem;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }

    /* Stats cards styling */
    .stats-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* Table styling */
    .table-responsive {
        border-radius: 0.375rem;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        color: #5a5c69;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table thead th.text-end {
        text-align: right !important;
    }

    .table tbody tr:hover {
        background-color: #f5f7fa;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .table tbody td .text-end {
        text-align: right !important;
    }

    /* Button group styling - better spacing */
    .d-flex.gap-1 > * {
        margin-right: 0.25rem;
    }

    .d-flex.gap-1 > *:last-child {
        margin-right: 0;
    }

    /* Action buttons styling */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }

    /* Badge styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Standard judul-modul */
    .judul-modul h3 {
        color: #5a5c69;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .judul-modul p {
        color: #858796;
        margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }

        .stats-card .card-body {
            padding: 1rem;
        }

        .stats-card h3 {
            font-size: 1.5rem;
        }

        .table-responsive {
            font-size: 0.875rem;
        }

        .d-flex.gap-1 {
            gap: 0.125rem !important;
        }

        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .judul-modul h3 {
            font-size: 1.5rem;
        }

        .judul-modul p {
            font-size: 0.9rem;
        }

        .card-body {
            padding: 15px;
        }

        .stats-card h3 {
            font-size: 1.25rem;
        }

        .table th, .table td {
            padding: 0.5rem;
            font-size: 0.8rem;
        }
    }
</style>
