{{-- resources/views/keuangan/transaksi/partials/styles.blade.php --}}
<style>
    /* ===========================================
       TRANSAKSI KEUANGAN STYLES
       =========================================== */

    .transaksi-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 10px;
    }

    .transaksi-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        transition: all 0.3s ease;
    }

    .transaksi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 2rem 0 rgba(58, 59, 69, 0.2);
    }

    .stats-card {
        border-left: 4px solid;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .border-left-primary { border-left-color: #4e73df !important; }
    .border-left-success { border-left-color: #1cc88a !important; }
    .border-left-warning { border-left-color: #f6c23e !important; }
    .border-left-info { border-left-color: #36b9cc !important; }
    .border-left-danger { border-left-color: #e74a3b !important; }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .badge-draft { background-color: #6c757d; color: white; }
    .badge-pending { background-color: #ffc107; color: #212529; }
    .badge-approved { background-color: #28a745; color: white; }
    .badge-rejected { background-color: #dc3545; color: white; }
    .badge-paid { background-color: #17a2b8; color: white; }

    .form-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .form-section h6 {
        color: #5a5c69;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e3e6f0;
    }

    .currency-input {
        text-align: right;
        font-family: 'Courier New', monospace;
        font-weight: bold;
    }

    .preview-card {
        background: #f8f9fc;
        border: 2px dashed #d1d3e2;
        border-radius: 8px;
        min-height: 300px;
        position: sticky;
        top: 20px;
    }

    .action-buttons {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        position: sticky;
        bottom: 20px;
        z-index: 100;
    }

    .transaction-timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #dee2e6;
    }

    .timeline-item.active::before {
        background: #28a745;
    }

    .filter-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .table thead th {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        color: #5a5c69;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr:hover {
        background-color: #f5f7fa;
    }

    .btn-action {
        margin: 0 2px;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }

    .development-alert {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

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

    @media (max-width: 768px) {
        .transaksi-header {
            padding: 1rem 0;
            margin-bottom: 1rem;
        }

        .form-section {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .stats-card {
            margin-bottom: 1rem;
        }

        .action-buttons {
            position: static;
            margin-top: 1rem;
        }
    }

    /* Print Styles */
    @media print {
        .no-print {
            display: none !important;
        }

        .print-only {
            display: block !important;
        }

        .transaksi-card {
            box-shadow: none;
            border: 1px solid #000;
        }
    }
</style>
