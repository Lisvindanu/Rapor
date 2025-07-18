{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\detail-styles.blade.php --}}
<style>
    /* Detail Page Styles - Clean Version */
    .section-detail {
        margin-bottom: 2rem;
        background: #fff;
        border-radius: 0.5rem;
        border: 1px solid #e3e6f0;
        overflow: hidden;
    }

    .section-title {
        color: #495057;
        font-weight: 600;
        font-size: 1.1rem;
        border-bottom: 2px solid #e9ecef;
        padding: 1rem 1.5rem;
        margin: 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.75rem;
        color: #0d6efd;
        font-size: 1.2rem;
    }

    .section-detail .row {
        padding: 1.5rem;
        margin: 0;
    }

    .detail-item {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.375rem;
        border-left: 4px solid #e9ecef;
        transition: all 0.2s ease-in-out;
    }

    .detail-item:hover {
        background: #f1f3f4;
        border-left-color: #0d6efd;
        transform: translateX(2px);
    }

    .detail-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 1rem;
        color: #495057;
        line-height: 1.5;
    }

    /* Badge Styles */
    .detail-value .badge {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%) !important;
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%) !important;
    }

    .badge.bg-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%) !important;
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #0dcaf0 0%, #17a2b8 100%) !important;
    }

    /* Section Divider */
    .section-divider {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #dee2e6, transparent);
        margin: 2rem 0;
    }

    /* Empty State */
    .detail-value .text-muted::before {
        content: "—";
        margin-right: 0.25rem;
        opacity: 0.7;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .section-detail {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1rem;
            padding: 0.75rem 1rem;
        }

        .section-detail .row {
            padding: 1rem;
        }

        .detail-item {
            margin-bottom: 1rem;
            padding: 0.75rem;
        }

        .detail-label {
            font-size: 0.8rem;
        }

        .detail-value {
            font-size: 0.9rem;
        }

        .badge {
            font-size: 0.75rem !important;
            padding: 0.375rem 0.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .section-title {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .section-title i {
            margin-right: 0;
            font-size: 1.5rem;
        }

        .detail-item {
            padding: 0.5rem;
        }

        .detail-label {
            font-size: 0.75rem;
        }

        .detail-value {
            font-size: 0.85rem;
        }
    }

    /* Animation */
    .detail-item {
        animation: fadeInUp 0.3s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
