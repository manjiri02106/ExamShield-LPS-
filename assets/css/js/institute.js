/**
 * ExamShield – Institute Module JavaScript
 * Handles: client-side search, form validation, flash auto-dismiss
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
       2. Search Form – Live Keyword Filter (index page)
       Filters institute info table rows by keyword
    ================================================ */
    const searchInput = document.getElementById('instituteSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            const rows    = document.querySelectorAll('.searchable-row');

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });

            // Show/hide empty notice
            const emptyNotice = document.getElementById('searchEmptyNotice');
            if (emptyNotice) {
                const visible = Array.from(rows).some(r => r.style.display !== 'none');
                emptyNotice.style.display = visible ? 'none' : '';
            }
        });
    }

    /* ================================================
       3. Institute Form Validation (add / edit pages)
    ================================================ */
    const instituteForm = document.getElementById('instituteForm');
    if (instituteForm) {
        instituteForm.addEventListener('submit', function (e) {

            let isValid = true;

            // Helper: set invalid state
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
            ['instituteName','instituteCode','email','phone','city','state','pincode','address'].forEach(clearInvalid);

            // Institute Name
            const name = document.getElementById('instituteName');
            if (name && name.value.trim().length < 3) {
                setInvalid('instituteName', 'Institute name must be at least 3 characters.');
            }

            // Institute Code
            const code = document.getElementById('instituteCode');
            if (code && code.value.trim() === '') {
                setInvalid('instituteCode', 'Institute code is required.');
            }

            // Email
            const email = document.getElementById('email');
            if (email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.value.trim())) {
                    setInvalid('email', 'Please enter a valid email address.');
                }
            }

            // Phone – digits only, 10 characters
            const phone = document.getElementById('phone');
            if (phone) {
                const phoneRegex = /^[0-9]{10}$/;
                if (!phoneRegex.test(phone.value.trim())) {
                    setInvalid('phone', 'Phone must be exactly 10 digits.');
                }
            }

            // City
            const city = document.getElementById('city');
            if (city && city.value.trim() === '') {
                setInvalid('city', 'City is required.');
            }

            // State
            const state = document.getElementById('state');
            if (state && state.value.trim() === '') {
                setInvalid('state', 'State is required.');
            }

            // Pincode – 6 digits
            const pincode = document.getElementById('pincode');
            if (pincode) {
                const pincodeRegex = /^[0-9]{6}$/;
                if (!pincodeRegex.test(pincode.value.trim())) {
                    setInvalid('pincode', 'Pincode must be exactly 6 digits.');
                }
            }

            // Address
            const address = document.getElementById('address');
            if (address && address.value.trim() === '') {
                setInvalid('address', 'Address is required.');
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });

        // Live clear invalid on user input
        instituteForm.querySelectorAll('.form-control, .form-select').forEach(function (el) {
            el.addEventListener('input', function () {
                this.classList.remove('is-invalid');
                const fb = this.parentNode.querySelector('.invalid-feedback');
                if (fb) fb.textContent = '';
            });
        });
    }

    /* ================================================
       4. Active Sidebar Link Highlight
    ================================================ */
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar a').forEach(function (link) {
        if (link.href && link.href.includes(currentPath.split('/').pop())) {
            link.classList.add('active');
        }
    });

});
