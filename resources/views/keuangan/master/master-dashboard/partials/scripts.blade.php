{{-- F:\rapor-dosen\resources\views\keuangan\master-dashboard\partials\scripts.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎯 Master Data Dashboard v1.1.0 - Production Ready');
        console.log('📊 Clean architecture without dummy data');

        // Remove any percentage text that might be added by other scripts
        removePercentageElements();

        // Stats card click handlers
        initializeStatsCards();

        // Master button hover effects
        initializeMasterButtons();

        // List item interactions
        initializeListItems();

        // Animate cards on load
        animateCards();

        console.log('✅ Master Data Dashboard ready - No dummy data');
    });

    function removePercentageElements() {
        // Find and remove any percentage elements that might exist
        const percentageElements = document.querySelectorAll('small');
        percentageElements.forEach(element => {
            const text = element.textContent.trim();
            if (text.includes('%') || text.includes('+') || text.includes('-')) {
                // Only remove if it's a percentage in stats cards
                const isInStatsCard = element.closest('.stats-card');
                if (isInStatsCard) {
                    element.remove();
                }
            }
        });
    }

    function initializeStatsCards() {
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach(card => {
            card.addEventListener('click', function() {
                const masterType = this.dataset.master;
                handleStatsCardClick(masterType);
            });

            // Ensure no percentage is added
            const cardBody = card.querySelector('.card-body');
            if (cardBody) {
                // Remove any small elements with percentages
                const smallElements = cardBody.querySelectorAll('small');
                smallElements.forEach(small => {
                    if (small.textContent.includes('%')) {
                        small.remove();
                    }
                });
            }
        });
    }

    function initializeMasterButtons() {
        const masterBtns = document.querySelectorAll('.master-btn');
        masterBtns.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'all 0.3s ease';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }

    function initializeListItems() {
        const listItems = document.querySelectorAll('.list-group-item');
        listItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'all 0.2s ease';
            });

            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = '';
            });
        });
    }

    function handleStatsCardClick(masterType) {
        const routes = {
            'mata-anggaran': '{{ route("keuangan.mata-anggaran.index") }}',
            'program': '{{ route("keuangan.program.index") }}',
            'sumber-dana': '{{ route("keuangan.sumber-dana.index") }}',
            'tahun-anggaran': '{{ route("keuangan.tahun-anggaran.index") }}',
            'tanda-tangan': '{{ route("keuangan.tanda-tangan.index") }}'
        };

        if (routes[masterType]) {
            window.location.href = routes[masterType];
        }
    }

    function animateCards() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in-up');
        });
    }

    // Clean up function to ensure no percentages are added
    function cleanupPercentages() {
        setTimeout(() => {
            removePercentageElements();
        }, 100);
    }

    // Run cleanup after page load
    window.addEventListener('load', cleanupPercentages);
</script>

<style>
    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
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
