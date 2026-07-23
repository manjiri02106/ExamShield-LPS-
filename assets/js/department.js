/**
 * ExamShield – department.js
 * Department module: search, pagination, delete confirm, form validation
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ── 1. Live Search ─────────────────────────────────── */
    var searchInput = document.getElementById('deptSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var kw  = this.value.toLowerCase().trim();
            var rows = document.querySelectorAll('.dept-row');
            var vis  = 0;
            rows.forEach(function (row) {
                var match = row.textContent.toLowerCase().includes(kw);
                row.style.display = match ? '' : 'none';
                if (match) vis++;
            });
            var emptyRow = document.getElementById('deptEmptySearch');
            if (emptyRow) emptyRow.style.display = vis === 0 ? '' : 'none';
            updatePagination();
        });
    }

    /* ── 2. Pagination ──────────────────────────────────── */
    var PER_PAGE = 10;
    var currentPage = 1;

    function updatePagination() {
        var allRows = Array.from(document.querySelectorAll('.dept-row')).filter(function (r) {
            return r.style.display !== 'none';
        });
        var total      = allRows.length;
        var totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;

        allRows.forEach(function (row, idx) {
            row.style.display = (idx >= (currentPage - 1) * PER_PAGE && idx < currentPage * PER_PAGE) ? '' : 'none';
        });

        var infoEl = document.getElementById('deptPageInfo');
        if (infoEl) {
            var start = total === 0 ? 0 : (currentPage - 1) * PER_PAGE + 1;
            var end   = Math.min(currentPage * PER_PAGE, total);
            infoEl.textContent = 'Showing ' + start + ' to ' + end + ' of ' + total + ' entries';
        }

        var paginEl = document.getElementById('deptPagination');
        if (!paginEl) return;
        paginEl.innerHTML = '';

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

        var next = document.createElement('button');
        next.className = 'es-page-btn';
        next.innerHTML = '<i class="fa-solid fa-chevron-right" style="font-size:11px;"></i>';
        next.disabled  = currentPage === totalPages;
        next.addEventListener('click', function () { if (currentPage < totalPages) { currentPage++; updatePagination(); } });
        paginEl.appendChild(next);
    }

    if (document.getElementById('deptPagination')) {
        updatePagination();
    }

    /* ── 3. SweetAlert2 Delete Confirmation ─────────────── */
    document.querySelectorAll('.dept-delete-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var id   = this.getAttribute('data-id');
            var name = this.getAttribute('data-name') || 'this department';
            Swal.fire({
                title: 'Delete Department?',
                html:  'You are about to delete <strong>' + name + '</strong>.<br>This cannot be undone.',
                icon:  'warning',
                showCancelButton:   true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor:  '#6b7280',
                confirmButtonText:  '<i class="fa-solid fa-trash"></i> Yes, Delete',
                cancelButtonText:   'Cancel',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Deleting...', allowOutsideClick: false, showConfirmButton: false,
                                didOpen: function () { Swal.showLoading(); } });
                    window.location.href = 'delete.php?id=' + id;
                }
            });
        });
    });

    /* ── 4. Institute Delete Confirmation ───────────────── */
    document.querySelectorAll('.inst-delete-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var id   = this.getAttribute('data-id');
            var name = this.getAttribute('data-name') || 'this institute';
            Swal.fire({
                title: 'Delete Institute?',
                html:  'You are about to delete <strong>' + name + '</strong>.<br>This cannot be undone.',
                icon:  'warning',
                showCancelButton:   true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor:  '#6b7280',
                confirmButtonText:  '<i class="fa-solid fa-trash"></i> Yes, Delete',
                cancelButtonText:   'Cancel',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = '../institute/delete.php?id=' + id;
                }
            });
        });
    });

    /* ── 5. Department Form Validation ──────────────────── */
    var form = document.getElementById('departmentForm');
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

            ['deptName','deptCode','hod','instituteId'].forEach(ok);

            var deptName = document.getElementById('deptName');
            if (deptName && deptName.value.trim().length < 2)
                fail('deptName', 'Department name must be at least 2 characters.');

            var deptCode = document.getElementById('deptCode');
            if (deptCode && deptCode.value.trim() === '')
                fail('deptCode', 'Department code is required.');
            else if (deptCode && !/^[A-Za-z0-9\-_]{2,20}$/.test(deptCode.value.trim()))
                fail('deptCode', 'Code must be 2–20 alphanumeric characters.');

            var hod = document.getElementById('hod');
            if (hod && hod.value.trim().length < 2)
                fail('hod', 'HOD name must be at least 2 characters.');

            var inst = document.getElementById('instituteId');
            if (inst && inst.value === '')
                fail('instituteId', 'Please select an institute.');

            if (!valid) {
                e.preventDefault();
                var first = form.querySelector('.is-invalid');
                if (first) { first.scrollIntoView({ behavior: 'smooth', block: 'center' }); first.focus(); }
            }
        });

        form.querySelectorAll('.form-control, .form-select').forEach(function (el) {
            el.addEventListener('input', function () { this.classList.remove('is-invalid'); });
        });

        // Auto-uppercase dept code
        var codeEl = document.getElementById('deptCode');
        if (codeEl) {
            codeEl.addEventListener('input', function () {
                var pos = this.selectionStart;
                this.value = this.value.toUpperCase();
                this.setSelectionRange(pos, pos);
            });
        }
    }

});
