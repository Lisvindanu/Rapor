{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\styles.blade.php --}}
<style>
    .kotak {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        margin-top: 10px;
        gap: 10px;
    }

    .kotak .card {
        flex: 0 0 auto;
        min-width: 200px;
        margin-right: 0;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .master-preview {
        border: 2px dashed #6c757d;
        padding: 2rem;
        text-align: center;
        background-color: #f8f9fa;
        margin: 1rem 0;
        border-radius: 5px;
    }

    .master-preview i {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .btn-group-master {
        margin-top: 10px;
    }

    .btn-group-master .btn {
        margin-right: 5px;
    }

    .master-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        font-family: Arial, sans-serif;
        overflow-x: auto;
        display: block;
        white-space: nowrap;
    }

    .master-table th,
    .master-table td {
        border: 1px solid #000;
        padding: 8px;
        min-width: 100px;
    }

    .master-table th {
        background-color: #f5f5f5;
        text-align: center;
    }

    .master-container {
        border: 1px solid #dee2e6;
        padding: 30px;
        background: white;
        font-family: Arial, sans-serif;
        overflow-x: auto;
    }

    /* Form Styles */
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

    /* Empty State */
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

    /* Table Enhancements */
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

    /* Button Groups */
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

    /* Badges */
    .badge {
        font-size: 0.75em;
        font-weight: 500;
    }

    .badge.small {
        font-size: 0.65em;
    }

    /* Cards */
    .card {
        border: 1px solid #e3e6f0;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }

        .kotak {
            flex-wrap: wrap;
            overflow-x: visible;
        }

        .kotak .card {
            flex: 1 1 100%;
            min-width: unset;
            margin-bottom: 10px;
        }

        .filter-konten .row .col-md-3,
        .filter-konten .row .col-md-6 {
            width: 100%;
            margin-bottom: 10px;
        }

        .filter-konten .btn-group-master {
            flex-direction: column;
            gap: 5px;
        }

        .filter-konten .btn-group-master .btn {
            width: 100%;
        }

        .master-container {
            padding: 15px;
        }

        .master-table {
            font-size: 10px;
        }

        .master-table th,
        .master-table td {
            padding: 4px;
            min-width: 80px;
        }

        .master-preview {
            padding: 1rem;
        }

        .master-preview i {
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin-bottom: 0.25rem;
        }
    }

    @media (max-width: 576px) {
        .master-table {
            font-size: 9px;
        }

        .master-table th,
        .master-table td {
            padding: 3px;
            min-width: 60px;
        }

        .judul-modul h3 {
            font-size: 1.5rem;
        }

        .judul-modul p {
            font-size: 0.9rem;
        }

        .filter-konten .form-control {
            font-size: 0.85rem;
        }

        .filter-konten .btn {
            font-size: 0.85rem;
            padding: 8px 12px;
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
