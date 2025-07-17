{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\styles.blade.php --}}
<style>
    /* ==== Master Data Base Styles ==== */
    .page-header {
        border-bottom: 1px solid #e3e6f0;
        padding-bottom: 1rem;
    }

    .judul-modul h3 {
        font-weight: 600;
        color: #2c3e50;
    }

    .judul-modul p {
        color: #6c757d;
        margin-bottom: 0;
    }

    /* ==== Table Styles ==== */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        background-color: #f8f9fa;
    }

    .table-dark th {
        background-color: #343a40 !important;
        color: #fff;
    }

    /* ==== Button Groups ==== */
    .btn-group .btn {
        border-radius: 0;
        padding: 0.25rem 0.5rem;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }

    /* ==== Badges ==== */
    .badge {
        font-size: 0.75em;
        font-weight: 500;
    }

    .badge.small {
        font-size: 0.65em;
    }

    /* ==== Cards ==== */
    .card {
        border: 1px solid #e3e6f0;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }

    /* ==== Forms ==== */
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
        color: #6c757d;
    }

    /* ==== Alerts ==== */
    .alert {
        border-radius: 0.5rem;
        border: none;
    }

    .alert-info {
        background-color: #e7f3ff;
        color: #0c5460;
        border-left: 4px solid #0dcaf0;
    }

    /* ==== Empty States ==== */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #adb5bd;
        margin-bottom: 1.5rem;
    }

    /* ==== Responsive Design ==== */
    @media (max-width: 768px) {
        .page-header {
            padding-bottom: 0.5rem;
        }

        .page-header .d-flex {
            flex-direction: column;
            align-items: stretch !important;
            gap: 1rem;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin-bottom: 0.25rem;
        }

        .table-responsive {
            font-size: 0.875rem;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding: 0 15px;
        }

        .card-body {
            padding: 1rem;
        }

        .table th, .table td {
            padding: 0.5rem 0.25rem;
            font-size: 0.8rem;
        }

        .badge {
            font-size: 0.7em;
        }
    }
</style>
