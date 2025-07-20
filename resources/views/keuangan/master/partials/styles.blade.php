{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\styles.blade.php --}}

{{-- CSRF Token - IMPORTANT untuk delete functionality --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* Essential Styles Only */
    .form-group {
        margin-bottom: 15px;
    }

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

    /* Button Groups */
    .btn-group-master {
        margin-top: 10px;
    }

    .btn-group-master .btn {
        margin-right: 5px;
    }

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

    /* Delete Modal Styling */
    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
    }

    /* Loading States */
    .btn:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
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
        .judul-modul h3 {
            font-size: 1.5rem;
        }

        .judul-modul p {
            font-size: 0.9rem;
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

    /* Signature Preview Styles */
    .signature-preview {
        max-width: 80px !important;
        max-height: 50px !important;
        object-fit: contain !important;
        display: block !important;
        margin: 0 auto !important;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background-color: white;
    }

    /* Force center alignment for TTD column */
    td:has(.signature-preview) {
        text-align: center !important;
        vertical-align: middle !important;
    }

    @media (max-width: 576px) {
        .judul-modul h3 {
            font-size: 1.5rem;
        }

        .judul-modul p {
            font-size: 0.9rem;
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

        .signature-preview {
            max-width: 60px !important;
            max-height: 40px !important;
        }
    }
</style>
