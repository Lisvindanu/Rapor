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

    .under-development {
        border: 2px dashed #6c757d;
        padding: 2rem;
        text-align: center;
        background-color: #f8f9fa;
        margin: 1rem 0;
    }

    .feature-card {
        opacity: 0.6;
        transition: opacity 0.3s;
    }

    .feature-card:hover {
        opacity: 1;
    }

    .quick-action-btn {
        transition: all 0.3s ease;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .stats-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .category-item {
        transition: all 0.2s ease;
    }

    .category-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .transaction-row {
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .transaction-row:hover {
        opacity: 1;
    }

    .statistics-cards {
        margin-bottom: 20px;
    }

    .isi-konten {
        margin-top: 20px;
    }

    .transaction-table {
        overflow-x: auto;
    }

    .transaction-table table {
        min-width: 600px;
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

        .isi-konten .row .col-6 {
            width: 100%;
            margin-bottom: 20px;
        }

        .statistics-cards .row {
            flex-direction: column;
        }

        .statistics-cards .col-md-3,
        .statistics-cards .col-md-4 {
            width: 100%;
            margin-bottom: 15px;
        }

        .transaction-table {
            font-size: 12px;
        }

        .transaction-table table {
            min-width: 400px;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 6px;
        }

        .navbar-nav {
            text-align: center;
        }

        .navbar-nav .nav-item {
            margin-bottom: 5px;
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

        .transaction-table {
            font-size: 11px;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 4px;
        }

        .btn {
            padding: 8px 12px;
            font-size: 0.875rem;
        }

        .dropdown-menu {
            font-size: 0.875rem;
        }
    }

    /* Horizontal layout optimization */
    .main-content-horizontal {
        display: flex;
        flex-wrap: nowrap;
        gap: 20px;
        overflow-x: auto;
        padding-bottom: 10px;
    }

    .main-content-horizontal .content-section {
        flex: 0 0 auto;
        min-width: 300px;
    }

    @media (max-width: 768px) {
        .main-content-horizontal {
            flex-direction: column;
            overflow-x: visible;
        }

        .main-content-horizontal .content-section {
            min-width: unset;
            width: 100%;
        }
    }
</style>
