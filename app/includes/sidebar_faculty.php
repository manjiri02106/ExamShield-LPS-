<?php
/*
|--------------------------------------------------------------------------
| Faculty Sidebar — ExamShield LPS
|--------------------------------------------------------------------------
| Matches sidebar_super_admin.php design exactly.
| Active link detection based on current filename + directory.
| Opens <div class="main-content"> wrapper (closed in each page's footer).
*/

$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir  = basename(dirname($_SERVER['PHP_SELF']));

/**
 * Return 'active' if the current page matches, else ''.
 * Supports both filename match and directory match.
 */
function facultySidebarActive(string $page, string $currentPage, string $dir = '', string $currentDir = ''): string {
    if ($page === $currentPage) return 'active';
    if ($dir && $dir === $currentDir) return 'active';
    return '';
}
?>

<div class="sidebar" id="mainSidebar">

    <!-- ── Logo / Brand ── -->
    <div class="sidebar-header">
        <a href="../dashboard/faculty.php" class="sidebar-logo" style="text-decoration:none;">
            <div class="sidebar-logo-icon" style="background: rgba(16,185,129,.15); color: #10b981;">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="sidebar-logo-text">
                <strong>ExamShield</strong>
                <span>Faculty Portal</span>
            </div>
        </a>
    </div>

    <!-- ── Navigation Menu ── -->
    <nav class="sidebar-menu" aria-label="Faculty navigation">

        <!-- MAIN -->
        <div class="menu-section-label">Main</div>

        <a href="../dashboard/faculty.php"
           class="<?php echo facultySidebarActive('faculty.php', $currentPage); ?>"
           id="facultyNavDashboard"
           title="Dashboard">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <!-- MY WORK -->
        <div class="menu-section-label">My Work</div>

        <a href="../faculty/question_bank/index.php"
           class="<?php echo facultySidebarActive('index.php', $currentPage, 'question_bank', $currentDir); ?>"
           id="facultyNavQuestionBank"
           title="Manage Questions">
            <i class="bi bi-patch-question"></i>
            <span>Manage Questions</span>
        </a>

        <a href="../faculty/question_bank/create.php"
           class="<?php echo facultySidebarActive('create.php', $currentPage, 'question_bank', $currentDir); ?>"
           id="facultyNavCreateQuestion"
           title="Create Question">
            <i class="bi bi-plus-circle"></i>
            <span>Create Question</span>
        </a>

        <!-- EXAMINATION -->
        <div class="menu-section-label">Examination</div>

        <a href="../faculty/exams/index.php"
           class="<?php echo facultySidebarActive('index.php', $currentPage, 'exams', $currentDir); ?>"
           id="facultyNavAssignedExams"
           title="Assigned Exams">
            <i class="bi bi-journal-check"></i>
            <span>Assigned Exams</span>
        </a>

        <a href="../faculty/results/index.php"
           class="<?php echo facultySidebarActive('index.php', $currentPage, 'results', $currentDir); ?>"
           id="facultyNavResults"
           title="Published Results">
            <i class="bi bi-clipboard-data"></i>
            <span>Published Results</span>
        </a>

        <!-- REPORTS & SYSTEM -->
        <div class="menu-section-label">Reports</div>

        <a href="../faculty/reports/index.php"
           class="<?php echo facultySidebarActive('index.php', $currentPage, 'reports', $currentDir); ?>"
           id="facultyNavReports"
           title="Reports">
            <i class="bi bi-bar-chart-line"></i>
            <span>Reports</span>
        </a>

        <!-- COMMUNICATION -->
        <div class="menu-section-label">Communication</div>

        <a href="../faculty/notifications/index.php"
           class="<?php echo facultySidebarActive('index.php', $currentPage, 'notifications', $currentDir); ?>"
           id="facultyNavNotifications"
           title="Notifications">
            <i class="bi bi-bell"></i>
            <span>Notifications</span>
        </a>

        <!-- ACCOUNT -->
        <div class="menu-section-label">Account</div>

        <a href="../profile/profile.php"
           class="<?php echo facultySidebarActive('profile.php', $currentPage); ?>"
           id="facultyNavProfile"
           title="Profile">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>

        <a href="../auth/change_password.php"
           class="<?php echo facultySidebarActive('change_password.php', $currentPage); ?>"
           id="facultyNavChangePassword"
           title="Change Password">
            <i class="bi bi-key"></i>
            <span>Change Password</span>
        </a>

        <a href="../auth/logout.php"
           class="logout-link"
           id="facultyNavLogout"
           title="Logout"
           onclick="return confirm('Are you sure you want to logout?');">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>

    </nav>

</div>

<!-- Main content wrapper — closed in each page before </body> -->
<div class="main-content" id="mainContent">