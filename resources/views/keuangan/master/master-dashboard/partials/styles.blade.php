{{-- F:\rapor-dosen\resources\views\keuangan\master-dashboard\partials\styles.blade.php --}}
<style>
    .stats-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .master-btn {
        transition: all 0.3s ease;
        margin-bottom: 8px;
    }

    .master-btn:hover {
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
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }

    .isi-konten {
        margin-top: 20px;
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

        .master-btn {
            font-size: 0.875rem;
            padding: 8px 12px;
        }

        .list-group-item {
            padding: 0.75rem;
        }
    }

    /* Animation */
    .stats-card {
        animation: fadeInUp 0.5s ease-out;
    }

    .master-btn {
        animation: fadeInLeft 0.5s ease-out;
    }

    .list-group-item {
        animation: fadeInRight 0.5s ease-out;
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
</style>
