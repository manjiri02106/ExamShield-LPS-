<?php
// Determine active page for nav highlighting
$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir  = basename(dirname($_SERVER['PHP_SELF']));

function sidebarActive(string $page, string $currentPage): string {
    return $currentPage === $page ? 'active' : '';
}
?>

<div class="sidebar" id="mainSidebar">

    <!-- ── Logo / Brand ── -->
    <div class="sidebar-header">
        <a href="../dashboard/super_admin.php" class="sidebar-logo" style="text-decoration:none;">
            <div class="sidebar-logo-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="sidebar-logo-text">
                <strong>ExamShield</strong>
                <span>Learning &amp; Proctoring Suite</span>
            </div>
        </a>
    </div>

    <!-- ── Navigation Menu ── -->
    <nav class="sidebar-menu" aria-label="Main navigation">

        <!-- MAIN -->
        <div class="menu-section-label">Main</div>

        <a href="../dashboard/super_admin.php"
           class="<?php echo sidebarActive('super_admin.php', $currentPage); ?>"
           id="sidenavDashboard"
           title="Dashboard">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <a href="#"
           class="<?php echo sidebarActive('institutes.php', $currentPage); ?>"
           id="sidenavInstitutes"
           title="Institutes">
            <i class="bi bi-building"></i>
            <span>Institutes</span>
        </a>

        <a href="../department/view_departments.php"
           class="<?php echo sidebarActive('view_departments.php', $currentPage); ?>"
           id="sidenavDepartments"
           title="Departments">
            <i class="bi bi-diagram-3"></i>
            <span>Departments</span>
        </a>

        <a href="../users/view_admins.php"
           class="<?php echo sidebarActive('view_admins.php', $currentPage); ?>"
           id="sidenavUsers"
           title="Users">
            <i class="bi bi-people"></i>
            <span>Users</span>
        </a>

        <a href="#"
           class="<?php echo sidebarActive('exams.php', $currentPage); ?>"
           id="sidenavExams"
           title="Exams">
            <i class="bi bi-journal-check"></i>
            <span>Exams</span>
        </a>

        <!-- REPORTS -->
        <div class="menu-section-label">Reports</div>

        <a href="#"
           class="<?php echo sidebarActive('reports.php', $currentPage); ?>"
           id="sidenavReports"
           title="Reports">
            <i class="bi bi-bar-chart-line"></i>
            <span>Reports</span>
        </a>

        <!-- SYSTEM -->
        <div class="menu-section-label">System</div>

        <a href="#"
           class="<?php echo sidebarActive('notifications.php', $currentPage); ?>"
           id="sidenavNotifications"
           title="Notifications">
            <i class="bi bi-bell"></i>
            <span>Notifications</span>
        </a>

        <a href="#"
           class="<?php echo sidebarActive('settings.php', $currentPage); ?>"
           id="sidenavSettings"
           title="Settings">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>

        <!-- ACCOUNT -->
        <div class="menu-section-label">Account</div>

        <a href="../profile/profile.php"
           class="<?php echo sidebarActive('profile.php', $currentPage); ?>"
           id="sidenavProfile"
           title="Profile">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>

        <a href="../auth/change_password.php"
           class="<?php echo sidebarActive('change_password.php', $currentPage); ?>"
           id="sidenavChangePassword"
           title="Change Password">
            <i class="bi bi-key"></i>
            <span>Change Password</span>
        </a>

        <a href="../auth/logout.php"
           class="logout-link"
           id="sidenavLogout"
           title="Logout"
           onclick="return confirm('Are you sure you want to logout?');">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>

    </nav>

</div>

<!-- Main content wrapper opens here; closed in footer.php -->
<div class="main-content" id="mainContent">