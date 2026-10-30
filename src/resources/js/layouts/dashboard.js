document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    if (toggle) {
        toggle.addEventListener('click', function () {
            if (window.innerWidth <= 991) {
                document.body.classList.toggle('sidebar-mobile-open');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            document.body.classList.remove('sidebar-mobile-open');
        });
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth > 991) {
            document.body.classList.remove('sidebar-mobile-open');
        }
    });

});