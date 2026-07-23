<?php
/*
|--------------------------------------------------------------------------
| Admin Sidebar — ExamShield LPS
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
function adminSidebarActive(string $page, string $currentPage, string $dir = '', string $currentDir = ''): string {
    if ($page === $currentPage) return 'active';
    if ($dir && $dir === $currentDir) return 'active';
    return '';
}
?>

<div class="sidebar" id="mainSidebar">

    <!-- ── Logo / Brand ── -->
    <div class="sidebar-header">
        <a href="../dashboard/admin.php" class="sidebar-logo" style="text-decoration:none;">
            <div class="sidebar-logo-icon">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div class="sidebar-logo-text">
                <strong>ExamShield</strong>
                <span>Admin Panel</span>
            </div>
        </a>
    </div>

    <!-- ── Navigation Menu ── -->
    <nav class="sidebar-menu" aria-label="Admin navigation">

        <!-- MAIN -->
        <div class="menu-section-label">Main</div>

        <a href="../dashboard/admin.php"
           class="<?php echo adminSidebarActive('admin.php', $currentPage); ?>"
           id="adminNavDashboard"
           title="Dashboard">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <!-- ACADEMIC -->
        <div class="menu-section-label">Academic</div>

        <a href="../admin/institute.php"
           class="<?php echo adminSidebarActive('institute.php', $currentPage); ?>"
           id="adminNavInstitute"
           title="Institute">
            <i class="bi bi-building"></i>
            <span>Institute</span>
        </a>

        <a href="../admin/departments/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'departments', $currentDir); ?>"
           id="adminNavDepartments"
           title="Departments">
            <i class="bi bi-diagram-3"></i>
            <span>Departments</span>
        </a>

        <a href="../admin/faculty/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'faculty', $currentDir); ?>"
           id="adminNavFaculty"
           title="Faculty">
            <i class="bi bi-person-badge"></i>
            <span>Faculty</span>
        </a>

        <a href="../admin/students/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'students', $currentDir); ?>"
           id="adminNavStudents"
           title="Students">
            <i class="bi bi-mortarboard"></i>
            <span>Students</span>
        </a>

        <a href="../admin/courses/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'courses', $currentDir); ?>"
           id="adminNavCourses"
           title="Courses">
            <i class="bi bi-journal-bookmark"></i>
            <span>Courses</span>
        </a>

        <a href="../admin/subjects/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'subjects', $currentDir); ?>"
           id="adminNavSubjects"
           title="Subjects">
            <i class="bi bi-book"></i>
            <span>Subjects</span>
        </a>

        <!-- EXAMINATION -->
        <div class="menu-section-label">Examination</div>

        <a href="../admin/question_bank/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'question_bank', $currentDir); ?>"
           id="adminNavQuestionBank"
           title="Question Bank">
            <i class="bi bi-patch-question"></i>
            <span>Question Bank</span>
        </a>

        <a href="../admin/exams/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'exams', $currentDir); ?>"
           id="adminNavExams"
           title="Exams">
            <i class="bi bi-journal-check"></i>
            <span>Exams</span>
        </a>

        <!-- REPORTS & SYSTEM -->
        <div class="menu-section-label">Reports</div>

        <a href="../admin/reports/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'reports', $currentDir); ?>"
           id="adminNavReports"
           title="Reports">
            <i class="bi bi-bar-chart-line"></i>
            <span>Reports</span>
        </a>

        <!-- SYSTEM -->
        <div class="menu-section-label">System</div>

        <a href="../admin/notifications/index.php"
           class="<?php echo adminSidebarActive('index.php', $currentPage, 'notifications', $currentDir); ?>"
           id="adminNavNotifications"
           title="Notifications">
            <i class="bi bi-bell"></i>
            <span>Notifications</span>
        </a>

        <!-- ACCOUNT -->
        <div class="menu-section-label">Account</div>

        <a href="../profile/profile.php"
           class="<?php echo adminSidebarActive('profile.php', $currentPage); ?>"
           id="adminNavProfile"
           title="Profile">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>

        <a href="../auth/change_password.php"
           class="<?php echo adminSidebarActive('change_password.php', $currentPage); ?>"
           id="adminNavChangePassword"
           title="Change Password">
            <i class="bi bi-key"></i>
            <span>Change Password</span>
        </a>

        <a href="../auth/logout.php"
           class="logout-link"
           id="adminNavLogout"
           title="Logout"
           onclick="return confirm('Are you sure you want to logout?');">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>

    </nav>

</div>

<!-- Main content wrapper — closed in each page before </body> -->
<div class="main-content" id="mainContent">