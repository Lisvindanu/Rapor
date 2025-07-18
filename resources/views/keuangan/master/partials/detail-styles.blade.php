{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\detail-styles.blade.php --}}
<style>
    /* Detail Page Enhancement Styles */
    .section-detail {
        margin-bottom: 2.5rem;
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
        word-break: break-word;
    }

    /* Badge Enhancements */
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
        box-shadow: 0 2px 4px rgba(25, 135, 84, 0.3);
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%) !important;
        box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
    }

    .badge.bg-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%) !important;
        box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #0dcaf0 0%, #17a2b8 100%) !important;
        box-shadow: 0 2px 4px rgba(13, 202, 240, 0.3);
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
        box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
        color: #000 !important;
    }

    /* Currency Display */
    .detail-value .text-success {
        font-weight: 700;
        font-size: 1.1rem;
        color: #198754 !important;
        text-shadow: 0 1px 2px rgba(25, 135, 84, 0.1);
    }

    .detail-value .text-muted {
        color: #adb5bd !important;
        font-style: italic;
    }

    /* Long Text Content */
    .longtext-content {
        font-size: 0.95rem;
        line-height: 1.7;
        border: 1px solid #dee2e6;
        background: #fff;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        max-height: 300px;
        overflow-y: auto;
    }

    /* Section Divider */
    .section-divider {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #dee2e6, transparent);
        margin: 3rem 0;
    }

    /* Empty State */
    .detail-value .text-muted {
        position: relative;
    }

    .detail-value .text-muted::before {
        content: "—";
        margin-right: 0.25rem;
        opacity: 0.7;
    }

    /* Datetime Display */
    .detail-value .text-muted.datetime {
        font-family: 'Consolas', 'Monaco', monospace;
        background: #f1f3f4;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }

    /* Status Icons */
    .badge i {
        margin-right: 0.25rem;
        font-size: 0.875em;
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

        .longtext-content {
            padding: 1rem;
            font-size: 0.875rem;
            max-height: 200px;
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

        .text-success {
            font-size: 1rem !important;
        }
    }

    /* Print Styles */
    @media print {
        .section-detail {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ccc;
        }

        .section-title {
            background: #f5f5f5 !important;
            color: #000 !important;
        }

        .detail-item {
            background: #fff !important;
            border: 1px solid #ddd;
            margin-bottom: 0.5rem;
        }

        .badge {
            border: 1px solid #000;
            background: #fff !important;
            color: #000 !important;
        }

        .text-success {
            color: #000 !important;
        }
    }

    /* Animation Effects */
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

    /* Loading States */
    .detail-loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }

    /* Hover Effects */
    .detail-item:hover .detail-label {
        color: #0d6efd;
        transition: color 0.2s ease-in-out;
    }

    .detail-item:hover .badge {
        transform: scale(1.05);
        transition: transform 0.2s ease-in-out;
    }

    /* Focus States */
    .detail-item:focus-within {
        outline: 2px solid #0d6efd;
        outline-offset: 2px;
    }

    /* Copy to Clipboard Button (if needed) */
    .detail-copy-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        border: none;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
    }

    .detail-item:hover .detail-copy-btn {
        opacity: 1;
    }

    /* Enhanced Typography */
    .detail-value strong {
        color: #212529;
        font-weight: 600;
    }

    .detail-value em {
        color: #6c757d;
        font-style: normal;
        background: #f8f9fa;
        padding: 0.125rem 0.25rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }

    /* Special Content Types */
    .detail-value .url-link {
        color: #0d6efd;
        text-decoration: none;
        border-bottom: 1px dotted #0d6efd;
    }

    .detail-value .url-link:hover {
        text-decoration: none;
        border-bottom-style: solid;
    }

    .detail-value .file-size {
        font-family: 'Consolas', monospace;
        background: #e9ecef;
        padding: 0.125rem 0.375rem;
        border-radius: 0.25rem;
        font-size: 0.8rem;
    }

    /* Grid Layout Enhancement */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
