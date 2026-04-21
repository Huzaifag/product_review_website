// JS for product card collapse/expand on mobile/tablet

document.addEventListener('DOMContentLoaded', function () {
    function isMobileOrTablet() {
        return window.innerWidth <= 991; // Bootstrap md breakpoint
    }

    document.querySelectorAll('.featured-lab-card').forEach(function(card) {
        var expand = card.querySelector('.featured-lab-expand');
        var arrow = card.querySelector('.featured-lab-hint');
        if (!expand || !arrow) return;

        function setInitialState() {
            if (isMobileOrTablet()) {
                expand.style.display = 'none';
                arrow.classList.remove('open');
            } else {
                expand.style.display = '';
                arrow.classList.add('open');
            }
        }

        setInitialState();
        window.addEventListener('resize', setInitialState);

        arrow.addEventListener('click', function(e) {
            if (!isMobileOrTablet()) return;
            e.preventDefault();
            if (expand.style.display === 'none') {
                expand.style.display = '';
                arrow.classList.add('open');
            } else {
                expand.style.display = 'none';
                arrow.classList.remove('open');
            }
        });
    });
});
