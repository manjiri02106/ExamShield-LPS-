/**
 * ExamShield – institute.js
 * Institute module: search filter, form validation, pagination
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ── 1. Live Search ─────────────────────────────────── */
    const searchInput = document.getElementById('instSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const kw   = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.inst-row');
            let   vis  = 0;
            rows.forEach(function (row) {
                const match = row.textContent.toLowerCase().includes(kw);
                row.style.display = match ? '' : 'none';
                if (match) vis++;
            });
            const emptyRow = document.getElementById('instEmptySearch');
            if (emptyRow) emptyRow.style.display = vis === 0 ? '' : 'none';
            updatePagination();
        });
    }

    /* ── 2. Pagination ──────────────────────────────────── */
    var PER_PAGE = 10;
    var currentPage = 1;

    function updatePagination() {
        var allRows = Array.from(document.querySelectorAll('.inst-row')).filter(function (r) {
            return r.style.display !== 'none';
        });
        var total     = allRows.length;
        var totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;

        allRows.forEach(function (row, idx) {
            row.style.display = (idx >= (currentPage - 1) * PER_PAGE && idx < currentPage * PER_PAGE) ? '' : 'none';
        });

        // Update info
        var infoEl = document.getElementById('instPageInfo');
        if (infoEl) {
            var start = total === 0 ? 0 : (currentPage - 1) * PER_PAGE + 1;
            var end   = Math.min(currentPage * PER_PAGE, total);
            infoEl.textContent = 'Showing ' + start + ' to ' + end + ' of ' + total + ' entries';
        }

        // Rebuild pagination buttons
        var paginEl = document.getElementById('instPagination');
        if (!paginEl) return;
        paginEl.innerHTML = '';

        // Prev
        var prev = document.createElement('button');
        prev.className = 'es-page-btn';
        prev.innerHTML = '<i class="fa-solid fa-chevron-left" style="font-size:11px;"></i>';
        prev.disabled  = currentPage === 1;
        prev.addEventListener('click', function () { if (currentPage > 1) { currentPage--; updatePagination(); } });
        paginEl.appendChild(prev);

        for (var p = 1; p <= totalPages; p++) {
            (function (pageNum) {
                var btn = document.createElement('button');
                btn.className = 'es-page-btn' + (pageNum === currentPage ? ' active' : '');
                btn.textContent = pageNum;
                btn.addEventListener('click', function () { currentPage = pageNum; updatePagination(); });
                paginEl.appendChild(btn);
            })(p);
        }

        // Next
        var next = document.createElement('button');
        next.className = 'es-page-btn';
        next.innerHTML = '<i class="fa-solid fa-chevron-right" style="font-size:11px;"></i>';
        next.disabled  = currentPage === totalPages;
        next.addEventListener('click', function () { if (currentPage < totalPages) { currentPage++; updatePagination(); } });
        paginEl.appendChild(next);
    }

    if (document.getElementById('instPagination')) {
        updatePagination();
    }

    /* ── 3. Institute Form Validation ───────────────────── */
    var form = document.getElementById('instituteForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            var valid = true;

            function fail(id, msg) {
                var el = document.getElementById(id);
                if (!el) return;
                el.classList.add('is-invalid');
                var fb = el.parentNode.querySelector('.invalid-feedback');
                if (fb) fb.textContent = msg;
                valid = false;
            }

            function ok(id) {
                var el = document.getElementById(id);
                if (el) el.classList.remove('is-invalid');
            }

            ['instituteName','instituteCode','email','phone','city','state','pincode','address'].forEach(ok);

            var name = document.getElementById('instituteName');
            if (name && name.value.trim().length < 3)
                fail('instituteName', 'Name must be at least 3 characters.');

            var code = document.getElementById('instituteCode');
            if (code && code.value.trim() === '')
                fail('instituteCode', 'Institute code is required.');

            var email = document.getElementById('email');
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim()))
                fail('email', 'Enter a valid email address.');

            var phone = document.getElementById('phone');
            if (phone && !/^[0-9]{10}$/.test(phone.value.trim()))
                fail('phone', 'Phone must be exactly 10 digits.');

            var city = document.getElementById('city');
            if (city && city.value.trim() === '')
                fail('city', 'City is required.');

            var state = document.getElementById('state');
            if (state && state.value.trim() === '')
                fail('state', 'State is required.');

            var pincode = document.getElementById('pincode');
            if (pincode && !/^[0-9]{6}$/.test(pincode.value.trim()))
                fail('pincode', 'Pincode must be exactly 6 digits.');

            var address = document.getElementById('address');
            if (address && address.value.trim() === '')
                fail('address', 'Address is required.');

            if (!valid) {
                e.preventDefault();
                var first = form.querySelector('.is-invalid');
                if (first) { first.scrollIntoView({ behavior: 'smooth', block: 'center' }); first.focus(); }
            }
        });

        // Live clear on input
        form.querySelectorAll('.form-control, .form-select').forEach(function (el) {
            el.addEventListener('input', function () { this.classList.remove('is-invalid'); });
        });
    }

});
