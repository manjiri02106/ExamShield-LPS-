<?php
$currentUser = $_SESSION['name'] ?? "User";
$currentRole = $_SESSION['role'] ?? "";
$userInitial = strtoupper(substr($currentUser, 0, 1));

// Format role label for display
$roleLabel = match($currentRole) {
    'SUPER_ADMIN' => 'Super Admin',
    'ADMIN'       => 'Admin',
    'FACULTY'     => 'Faculty',
    'STUDENT'     => 'Student',
    default       => htmlspecialchars($currentRole),
};
?>

<nav class="navbar navbar-expand-lg">

    <div class="container-fluid d-flex align-items-center justify-content-between w-100">

        <!-- Left: Page context -->
        <div class="d-flex align-items-center gap-3">

            <!-- Mobile toggle -->
            <button
                id="sidebarToggle"
                class="nav-icon-btn d-lg-none"
                type="button"
                title="Toggle Menu"
                aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <div class="navbar-page-title" id="navPageTitle">Dashboard</div>
                <div class="navbar-breadcrumb">
                    <i class="bi bi-house-fill"></i>
                    Home
                    <i class="bi bi-chevron-right"></i>
                    <span id="navBreadcrumb">Dashboard</span>
                </div>
            </div>

        </div>

        <!-- Right: Actions -->
        <div class="d-flex align-items-center gap-3">

            <!-- Notification Bell -->
            <div class="position-relative">
                <a href="#" class="nav-icon-btn" id="notificationBtn" title="Notifications" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="badge-dot"></span>
                </a>
            </div>

            <!-- Divider -->
            <div style="width:1px;height:32px;background:var(--border);"></div>

            <!-- User Dropdown -->
            <div class="dropdown">

                <button
                    class="nav-user-btn dropdown-toggle border-0 bg-transparent p-0"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    id="userMenuBtn"
                    aria-label="User menu">

                    <div class="nav-avatar">
                        <?php echo $userInitial; ?>
                    </div>

                    <div class="nav-user-info d-none d-sm-flex">
                        <span class="nav-user-name"><?php echo htmlspecialchars($currentUser); ?></span>
                        <span class="nav-user-role"><?php echo $roleLabel; ?></span>
                    </div>

                    <i class="bi bi-chevron-down nav-dropdown-icon d-none d-sm-block"></i>

                </button>

                <ul class="dropdown-menu dropdown-menu-end nav-dropdown-menu">

                    <!-- User info header -->
                    <li class="px-3 py-2 mb-1" style="border-bottom:1px solid var(--border);">
                        <div style="font-size:13px;font-weight:700;color:var(--text-primary);">
                            <?php echo htmlspecialchars($currentUser); ?>
                        </div>
                        <div style="font-size:11px;color:var(--text-secondary);">
                            <?php echo $roleLabel; ?>
                        </div>
                    </li>

                    <li>
                        <a class="dropdown-item" href="../profile/profile.php" id="navProfileLink">
                            <i class="bi bi-person-circle"></i>
                            My Profile
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="../auth/change_password.php" id="navChangePassLink">
                            <i class="bi bi-key-fill"></i>
                            Change Password
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item text-danger" href="../auth/logout.php" id="navLogoutLink">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>

<script>
// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar   = document.querySelector('.sidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
        });
        // Close on outside click
        document.addEventListener('click', function (e) {
            if (sidebar.classList.contains('mobile-open') &&
                !sidebar.contains(e.target) &&
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    }
});
</script>