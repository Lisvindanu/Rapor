{{-- F:\rapor-dosen\resources\views\keuangan\transaksi\transaksi-dashboard\partials\styles.blade.php --}}
<style>
    /* Basic card styling - same as master */
    .card {
        border: 1px solid #e3e6f0;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.375rem;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }

    /* Stats cards - simple without gradient */
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

    /* Standard button styling */
    .transaksi-btn {
        transition: all 0.3s ease;
        margin-bottom: 8px;
        border: none;
    }

    .transaksi-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* List group styling */
    .list-group-item {
        border: 1px solid #e3e6f0;
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    /* Standard layout */
    .isi-konten {
        margin-top: 20px;
    }

    .judul-modul h3 {
        color: #5a5c69;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .judul-modul p {
        color: #858796;
        margin-bottom: 0;
    }

    /* Simple solid colors - no gradients */
    .bg-primary {
        background-color: #4e73df !important;
    }

    .bg-warning {
        background-color: #f6c23e !important;
    }

    .bg-success {
        background-color: #1cc88a !important;
    }

    .bg-info {
        background-color: #36b9cc !important;
    }

    .bg-danger {
        background-color: #e74a3b !important;
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

    .table tbody tr:hover {
        background-color: #f5f7fa;
    }

    .btn-group .btn {
        margin: 0 1px;
    }

    /* Badge styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    /* Alert styling */
    .alert {
        border: none;
        border-radius: 0.5rem;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }

        .isi-konten .row .col-6 {
            width: 100%;
            margin-bottom: 20px;
        }

        .col-md-2 {
            width: 50%;
            margin-bottom: 15px;
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

        .btn-group .btn {
            padding: 0.25rem 0.5rem;
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

        .col-md-2 {
            width: 100%;
        }

        .card-body {
            padding: 15px;
        }

        .transaksi-btn {
            font-size: 0.875rem;
            padding: 8px 12px;
        }

        .list-group-item {
            padding: 0.75rem;
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
