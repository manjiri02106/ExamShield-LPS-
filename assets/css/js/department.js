/**
 * ExamShield – Department Module JavaScript
 * Handles: SweetAlert2 delete confirmation, client-side search,
 *          form validation, flash auto-dismiss
 */

document.addEventListener('DOMContentLoaded', function () {

    /* ================================================
       1. Flash Message Auto-Dismiss (4 seconds)
    ================================================ */
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(function (msg) {
        setTimeout(function () {
            msg.style.transition = 'opacity 0.5s ease';
            msg.style.opacity   = '0';
            setTimeout(function () {
                msg.remove();
            }, 500);
        }, 4000);
    });

    /* ================================================
       2. SweetAlert2 Delete Confirmation
       Each delete button must have:
         data-dept-id="<id>"
         data-dept-name="<name>"
    ================================================ */
    const deleteButtons = document.querySelectorAll('.dept-delete-btn');
    deleteButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const deptId   = this.getAttribute('data-dept-id');
            const deptName = this.getAttribute('data-dept-name') || 'this department';

            Swal.fire({
                title: 'Delete Department?',
                html:  'You are about to delete <strong>' + deptName + '</strong>.<br>This action <strong>cannot be undone</strong>.',
                icon:  'warning',
                showCancelButton:   true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor:  '#6b7280',
                confirmButtonText:  '<i class="bi bi-trash3-fill"></i> Yes, Delete',
                cancelButtonText:   'Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'swal-confirm-btn',
                    cancelButton:  'swal-cancel-btn'
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: function () {
                            Swal.showLoading();
                        }
                    });
                    // Redirect to delete.php
                    window.location.href = 'delete.php?id=' + deptId;
                }
            });
        });
    });

    /* ================================================
       3. Live Client-Side Search (department list)
       Filters table rows by text content
    ================================================ */
    const searchInput = document.getElementById('deptSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword  = this.value.toLowerCase().trim();
            const rows     = document.querySelectorAll('.dept-table-row');
            let   visible  = 0;

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                if (text.includes(keyword)) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show/hide empty state
            const emptyRow = document.getElementById('deptEmptySearch');
            if (emptyRow) {
                emptyRow.style.display = (visible === 0) ? '' : 'none';
            }

            // Update result count label
            const countLabel = document.getElementById('deptResultCount');
            if (countLabel) {
                countLabel.textContent = keyword
                    ? 'Showing ' + visible + ' result(s) for "' + keyword + '"'
                    : '';
            }
        });
    }

    /* ================================================
       4. Department Form Validation (add / edit)
    ================================================ */
    const deptForm = document.getElementById('departmentForm');
    if (deptForm) {
        deptForm.addEventListener('submit', function (e) {

            let isValid = true;

            function setInvalid(fieldId, message) {
                const el = document.getElementById(fieldId);
                if (!el) return;
                el.classList.add('is-invalid');
                let fb = el.parentNode.querySelector('.invalid-feedback');
                if (!fb) {
                    fb = document.createElement('div');
                    fb.className = 'invalid-feedback';
                    el.parentNode.appendChild(fb);
                }
                fb.textContent = message;
                isValid = false;
            }

            function clearInvalid(fieldId) {
                const el = document.getElementById(fieldId);
                if (!el) return;
                el.classList.remove('is-invalid');
                const fb = el.parentNode.querySelector('.invalid-feedback');
                if (fb) fb.textContent = '';
            }

            // Reset all
            ['deptName','deptCode','hod','instituteId','status'].forEach(clearInvalid);

            // Department Name
            const deptName = document.getElementById('deptName');
            if (deptName && deptName.value.trim().length < 2) {
                setInvalid('deptName', 'Department name must be at least 2 characters.');
            }

            // Department Code
            const deptCode = document.getElementById('deptCode');
            if (deptCode && deptCode.value.trim() === '') {
                setInvalid('deptCode', 'Department code is required.');
            } else if (deptCode && !/^[A-Za-z0-9\-_]{2,20}$/.test(deptCode.value.trim())) {
                setInvalid('deptCode', 'Code must be 2-20 alphanumeric characters.');
            }

            // HOD
            const hod = document.getElementById('hod');
            if (hod && hod.value.trim().length < 2) {
                setInvalid('hod', 'Head of Department name must be at least 2 characters.');
            }

            // Institute
            const instituteId = document.getElementById('instituteId');
            if (instituteId && instituteId.value === '') {
                setInvalid('instituteId', 'Please select an institute.');
            }

            if (!isValid) {
                e.preventDefault();
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });

        // Live clear on user input
        deptForm.querySelectorAll('.form-control, .form-select').forEach(function (el) {
            el.addEventListener('input', function () {
                this.classList.remove('is-invalid');
                const fb = this.parentNode.querySelector('.invalid-feedback');
                if (fb) fb.textContent = '';
            });
        });

        // Auto uppercase department code
        const deptCodeEl = document.getElementById('deptCode');
        if (deptCodeEl) {
            deptCodeEl.addEventListener('input', function () {
                const pos = this.selectionStart;
                this.value = this.value.toUpperCase();
                this.setSelectionRange(pos, pos);
            });
        }
    }

    /* ================================================
       5. Active Sidebar Link Highlight
    ================================================ */
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('.sidebar a').forEach(function (link) {
        const href = link.getAttribute('href') || '';
        if (href.includes(currentPage) && currentPage !== '') {
            link.classList.add('active');
        }
    });

});
