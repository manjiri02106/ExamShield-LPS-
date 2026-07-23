<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only SUPER_ADMIN can access this page
checkRole("SUPER_ADMIN");

// Fetch departments
$sql    = "SELECT id, department_name FROM departments ORDER BY department_name ASC";
$result = $conn->query($sql);

require_once "../includes/header.php";
require_once "../includes/sidebar_super_admin.php";
require_once "../includes/navbar.php";
?>

<!-- Page-specific CSS -->
<link rel="stylesheet" href="../../assets/css/create_admin.css">

<div class="content-wrapper">

    <!-- ── Page Header ── -->
    <div class="ca-page-header">

        <div class="ca-breadcrumb">
            <i class="bi bi-house-fill"></i>
            <a href="../dashboard/super_admin.php">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <a href="view_admins.php">Users</a>
            <i class="bi bi-chevron-right"></i>
            <span>Create Admin</span>
        </div>

        <div class="ca-page-title-wrap">
            <div class="ca-page-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <div>
                <h1 class="ca-page-title">Create Admin</h1>
                <p class="ca-page-subtitle">Create a new administrator account for the system.</p>
            </div>
        </div>

    </div>

    <!-- ── Form Card ── -->
    <div class="ca-card">

        <!-- Card Header -->
        <div class="ca-card-header">
            <div class="ca-card-header-icon">
                <i class="bi bi-person-gear"></i>
            </div>
            <div>
                <div class="ca-card-header-title">Admin Account Details</div>
                <div class="ca-card-header-sub">All fields are required. The admin can change their password after first login.</div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="ca-card-body">

            <?php
            // Display flash messages if any (from session)
            if (isset($_SESSION['flash_success'])): ?>
                <div class="ca-alert ca-alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <div><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="ca-alert ca-alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
                </div>
            <?php endif; ?>

            <form action="create_admin_process.php" method="POST" id="createAdminForm" novalidate>

                <!-- ── Name + Email ── -->
                <div class="ca-row">

                    <!-- Admin Name -->
                    <div class="ca-form-group">
                        <label class="ca-form-label" for="adminName">
                            <i class="bi bi-person"></i>
                            Admin Name
                            <span class="required-star">*</span>
                        </label>
                        <div class="ca-input-wrap">
                            <input
                                type="text"
                                id="adminName"
                                name="name"
                                class="ca-input"
                                placeholder="e.g. John Smith"
                                required
                                autocomplete="name"
                                maxlength="100">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="ca-form-group">
                        <label class="ca-form-label" for="adminEmail">
                            <i class="bi bi-envelope"></i>
                            Email Address
                            <span class="required-star">*</span>
                        </label>
                        <div class="ca-input-wrap">
                            <input
                                type="email"
                                id="adminEmail"
                                name="email"
                                class="ca-input"
                                placeholder="e.g. john@institution.edu"
                                required
                                autocomplete="email"
                                maxlength="150">
                        </div>
                    </div>

                </div><!-- /ca-row -->

                <div class="ca-section-divider">Security</div>

                <!-- Password -->
                <div class="ca-form-group">
                    <label class="ca-form-label" for="adminPassword">
                        <i class="bi bi-lock"></i>
                        Default Password
                        <span class="required-star">*</span>
                    </label>
                    <div class="ca-input-wrap">
                        <input
                            type="password"
                            id="adminPassword"
                            name="password"
                            class="ca-input has-icon"
                            placeholder="Set a temporary password"
                            required
                            autocomplete="new-password"
                            maxlength="100">
                        <button
                            type="button"
                            class="ca-input-icon-right"
                            id="togglePassword"
                            title="Show / Hide password"
                            aria-label="Toggle password visibility">
                            <i class="bi bi-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>

                    <!-- Strength bar -->
                    <div class="ca-strength-bar" id="strengthBar" aria-hidden="true">
                        <div class="ca-strength-segment" id="seg1"></div>
                        <div class="ca-strength-segment" id="seg2"></div>
                        <div class="ca-strength-segment" id="seg3"></div>
                        <div class="ca-strength-segment" id="seg4"></div>
                    </div>
                    <div class="ca-strength-label" id="strengthLabel"></div>

                    <div class="ca-helper-text">
                        <i class="bi bi-info-circle"></i>
                        The admin should change this password immediately after their first login.
                    </div>
                </div>

                <div class="ca-section-divider">Assignment</div>

                <!-- Department -->
                <div class="ca-form-group">
                    <label class="ca-form-label" for="adminDept">
                        <i class="bi bi-diagram-3"></i>
                        Department
                        <span class="required-star">*</span>
                    </label>
                    <select
                        id="adminDept"
                        name="department_id"
                        class="ca-input"
                        required>

                        <option value="" disabled selected>— Select a department —</option>

                        <?php while ($department = $result->fetch_assoc()): ?>
                        <option value="<?php echo $department['id']; ?>">
                            <?php echo htmlspecialchars($department['department_name']); ?>
                        </option>
                        <?php endwhile; ?>

                    </select>
                </div>

                <!-- Role badge (read-only info) -->
                <div class="ca-form-group">
                    <label class="ca-form-label">
                        <i class="bi bi-shield-check"></i>
                        Assigned Role
                    </label>
                    <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f8fafc;border:1.5px solid var(--border);border-radius:var(--input-radius);">
                        <span style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:20px;background:rgba(16,185,129,0.1);color:#10b981;font-size:12px;font-weight:700;">
                            <i class="bi bi-person-badge-fill"></i> ADMIN
                        </span>
                        <span style="font-size:12px;color:var(--text-secondary);">Role is automatically assigned by the system.</span>
                    </div>
                </div>

            </form>

        </div><!-- /ca-card-body -->

        <!-- Card Footer / Buttons -->
        <div class="ca-card-footer">
            <button
                type="submit"
                form="createAdminForm"
                class="btn-ca-primary"
                id="btnCreateAdmin">
                <i class="bi bi-person-plus-fill"></i>
                Create Admin
            </button>
            <a
                href="../dashboard/super_admin.php"
                class="btn-ca-secondary"
                id="btnBackDashboard">
                <i class="bi bi-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>

    </div><!-- /ca-card -->

</div><!-- /content-wrapper -->

<!-- ── Footer + Scripts ── -->
</div><!-- /main-content (opened in sidebar) -->

<footer class="dashboard-footer" style="margin-left:var(--sidebar-width);transition:margin-left .25s ease;">
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Learning &amp; Proctoring Suite. All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ─── Toggle Password Visibility ─── */
    const pwInput  = document.getElementById('adminPassword');
    const toggleBtn = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (toggleBtn && pwInput) {
        toggleBtn.addEventListener('click', function () {
            const isHidden = pwInput.type === 'password';
            pwInput.type = isHidden ? 'text' : 'password';
            toggleIcon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    }

    /* ─── Password Strength ─── */
    const segs  = [
        document.getElementById('seg1'),
        document.getElementById('seg2'),
        document.getElementById('seg3'),
        document.getElementById('seg4'),
    ];
    const strengthLabel = document.getElementById('strengthLabel');

    function measureStrength(pw) {
        if (!pw) return 0;
        let score = 0;
        if (pw.length >= 8)                   score++;
        if (/[A-Z]/.test(pw))                 score++;
        if (/[0-9]/.test(pw))                 score++;
        if (/[^A-Za-z0-9]/.test(pw))          score++;
        return score; // 0-4
    }

    const levels = ['', 'weak', 'fair', 'good', 'strong'];
    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];

    if (pwInput) {
        pwInput.addEventListener('input', function () {
            const score = measureStrength(this.value);
            segs.forEach(function (s, i) {
                s.className = 'ca-strength-segment';
                if (i < score && score > 0) s.classList.add(levels[score]);
            });
            strengthLabel.className = 'ca-strength-label' + (score ? ' ' + levels[score] : '');
            strengthLabel.textContent = this.value ? labels[score] : '';
        });
    }

    /* ─── Responsive Footer Margin ─── */
    function updateFooterMargin() {
        const footer = document.querySelector('.dashboard-footer');
        if (!footer) return;
        footer.style.marginLeft = window.innerWidth <= 768 ? '0' :
            getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width').trim();
    }
    updateFooterMargin();
    window.addEventListener('resize', updateFooterMargin);

    /* ─── Basic Client-side Validation ─── */
    const form = document.getElementById('createAdminForm');
    const submitBtn = document.getElementById('btnCreateAdmin');

    if (form) {
        form.addEventListener('submit', function (e) {
            const name  = document.getElementById('adminName').value.trim();
            const email = document.getElementById('adminEmail').value.trim();
            const pass  = document.getElementById('adminPassword').value.trim();
            const dept  = document.getElementById('adminDept').value;

            if (!name || !email || !pass || !dept) {
                e.preventDefault();
                // Light shake animation on button
                submitBtn.style.transform = 'translateX(-6px)';
                setTimeout(function() { submitBtn.style.transform = 'translateX(6px)'; }, 100);
                setTimeout(function() { submitBtn.style.transform = ''; }, 200);
                return;
            }

            // Show loading state
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Creating…';
            submitBtn.disabled = true;
        });
    }

});
</script>

</body>
</html>