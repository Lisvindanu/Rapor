{{-- F:\rapor-dosen\resources\views\keuangan\transaksi\transaksi-dashboard\partials\styles.blade.php --}}
<style>
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

    .transaksi-btn {
        transition: all 0.3s ease;
        margin-bottom: 8px;
        border: none;
    }

    .transaksi-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .list-group-item {
        border: 1px solid #e3e6f0;
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .card {
        border: 1px solid #e3e6f0;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.375rem;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }

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

    /* Transaction specific styles */
    .bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
    }

    .bg-success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
    }

    .bg-info {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%) !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%) !important;
    }

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

    /* Badge styles */
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    /* Alert styles */
    .alert {
        border: none;
        border-radius: 0.5rem;
    }

    .alert-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .alert-info .btn-close {
        filter: brightness(0) invert(1);
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

    /* Animation */
    .stats-card {
        animation: fadeInUp 0.5s ease-out;
    }

    .transaksi-btn {
        animation: fadeInLeft 0.5s ease-out;
    }

    .list-group-item {
        animation: fadeInRight 0.5s ease-out;
    }

    .card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Loading states */
    .loading-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, transparent 37%, #f0f0f0 63%);
        background-size: 400% 100%;
        animation: loading 1.4s ease infinite;
    }

    @keyframes loading {
        0% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    /* Status indicators */
    .status-indicator {
        position: relative;
        padding-left: 1.5rem;
    }

    .status-indicator::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: currentColor;
    }

    .status-draft::before { background-color: #6c757d; }
    .status-pending::before { background-color: #ffc107; }
    .status-approved::before { background-color: #28a745; }
    .status-rejected::before { background-color: #dc3545; }
    .status-paid::before { background-color: #17a2b8; }
</style>
