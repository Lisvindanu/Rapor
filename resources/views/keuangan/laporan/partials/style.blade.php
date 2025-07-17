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

    /* Horizontal layout untuk quick actions */
    .quick-actions-horizontal {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 10px;
        padding-bottom: 10px;
    }

    .quick-actions-horizontal .btn {
        flex: 0 0 auto;
        min-width: 150px;
        white-space: nowrap;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .laporan-preview {
        border: 2px dashed #6c757d;
        padding: 2rem;
        text-align: center;
        background-color: #f8f9fa;
        margin: 1rem 0;
        border-radius: 5px;
    }

    .laporan-preview i {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }

    .btn-group-laporan {
        margin-top: 10px;
    }

    .btn-group-laporan .btn {
        margin-right: 5px;
    }

    .preview-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        font-family: Arial, sans-serif;
        overflow-x: auto;
        display: block;
        white-space: nowrap;
    }

    .preview-table th,
    .preview-table td {
        border: 1px solid #000;
        padding: 8px;
        min-width: 100px;
    }

    .preview-table th {
        background-color: #f5f5f5;
        text-align: center;
    }

    .preview-container {
        border: 1px solid #dee2e6;
        padding: 30px;
        background: white;
        font-family: Arial, sans-serif;
        overflow-x: auto;
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

        .filter-konten .row .col-md-3 {
            width: 100%;
            margin-bottom: 10px;
        }

        .filter-konten .btn-group-laporan {
            flex-direction: column;
            gap: 5px;
        }

        .filter-konten .btn-group-laporan .btn {
            width: 100%;
        }

        .preview-container {
            padding: 15px;
        }

        .preview-table {
            font-size: 10px;
        }

        .preview-table th,
        .preview-table td {
            padding: 4px;
            min-width: 80px;
        }

        .laporan-preview {
            padding: 1rem;
        }

        .laporan-preview i {
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 10px;
        }

        /* Quick actions responsive */
        .quick-actions-horizontal {
            flex-direction: column;
            gap: 10px;
        }

        .quick-actions-horizontal .btn {
            width: 100%;
            min-width: unset;
        }
    }

    @media (max-width: 576px) {
        .preview-table {
            font-size: 9px;
        }

        .preview-table th,
        .preview-table td {
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
    }
</style>
