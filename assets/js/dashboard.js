/**
 * ExamShield – dashboard.js
 * Shared JS for Institute & Department admin pages
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Flash Auto-Dismiss (4s) ───────────────────────── */
    document.querySelectorAll('.es-flash').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 500);
        }, 4000);
    });

    /* ── Mobile Sidebar Toggle ─────────────────────────── */
    const sidebar  = document.querySelector('.es-sidebar');
    const toggler  = document.getElementById('sidebarToggle');
    const overlay  = document.getElementById('sidebarOverlay');

    if (toggler && sidebar) {
        toggler.addEventListener('click', function () {
            sidebar.classList.toggle('open');
            if (overlay) overlay.classList.toggle('show');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            if (sidebar) sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    }

    /* ── Tooltip Init (Bootstrap) ──────────────────────── */
    if (typeof bootstrap !== 'undefined') {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    }

});
