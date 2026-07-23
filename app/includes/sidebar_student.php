<?php
/*
|--------------------------------------------------------------------------
| Student Sidebar — ExamShield LPS
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
function studentSidebarActive(string $page, string $currentPage, string $dir = '', string $currentDir = ''): string {
    if ($page === $currentPage) return 'active';
    if ($dir && $dir === $currentDir) return 'active';
    return '';
}
?>

<div class="sidebar" id="mainSidebar">

    <!-- ── Logo / Brand ── -->
    <div class="sidebar-header">
        <a href="../dashboard/student.php" class="sidebar-logo" style="text-decoration:none;">
            <div class="sidebar-logo-icon" style="background: rgba(99,102,241,.15); color: #6366f1;">
                <i class="bi bi-journal-text"></i>
            </div>
            <div class="sidebar-logo-text">
                <strong>ExamShield</strong>
                <span>Student Portal</span>
            </div>
        </a>
    </div>

    <!-- ── Navigation Menu ── -->
    <nav class="sidebar-menu" aria-label="Student navigation">

        <!-- MAIN -->
        <div class="menu-section-label">Main</div>

        <a href="../dashboard/student.php"
           class="<?php echo studentSidebarActive('student.php', $currentPage); ?>"
           id="studentNavDashboard"
           title="Dashboard">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <!-- MY LEARNING -->
        <div class="menu-section-label">My Learning</div>

        <a href="../student/courses/index.php"
           class="<?php echo studentSidebarActive('index.php', $currentPage, 'courses', $currentDir); ?>"
           id="studentNavCourses"
           title="My Courses">
            <i class="bi bi-journal-bookmark"></i>
            <span>My Courses</span>
        </a>

        <a href="../student/subjects/index.php"
           class="<?php echo studentSidebarActive('index.php', $currentPage, 'subjects', $currentDir); ?>"
           id="studentNavSubjects"
           title="My Subjects">
            <i class="bi bi-book"></i>
            <span>My Subjects</span>
        </a>

        <!-- EXAMINATIONS -->
        <div class="menu-section-label">Examinations</div>

        <a href="../student/exams/upcoming.php"
           class="<?php echo studentSidebarActive('upcoming.php', $currentPage, 'exams', $currentDir); ?>"
           id="studentNavUpcomingExams"
           title="Upcoming Exams">
            <i class="bi bi-calendar-event"></i>
            <span>Upcoming Exams</span>
        </a>

        <a href="../student/exams/take.php"
           class="<?php echo studentSidebarActive('take.php', $currentPage, 'exams', $currentDir); ?>"
           id="studentNavTakeExam"
           title="Take Exam">
            <i class="bi bi-pencil-square"></i>
            <span>Take Exam</span>
        </a>

        <a href="../student/exams/history.php"
           class="<?php echo studentSidebarActive('history.php', $currentPage, 'exams', $currentDir); ?>"
           id="studentNavExamHistory"
           title="Exam History">
            <i class="bi bi-clock-history"></i>
            <span>Exam History</span>
        </a>

        <a href="../student/results/index.php"
           class="<?php echo studentSidebarActive('index.php', $currentPage, 'results', $currentDir); ?>"
           id="studentNavResults"
           title="Results">
            <i class="bi bi-award"></i>
            <span>Results</span>
        </a>

        <!-- COMMUNICATION -->
        <div class="menu-section-label">Communication</div>

        <a href="../student/notifications/index.php"
           class="<?php echo studentSidebarActive('index.php', $currentPage, 'notifications', $currentDir); ?>"
           id="studentNavNotifications"
           title="Notifications">
            <i class="bi bi-bell"></i>
            <span>Notifications</span>
        </a>

        <!-- ACCOUNT -->
        <div class="menu-section-label">Account</div>

        <a href="../profile/profile.php"
           class="<?php echo studentSidebarActive('profile.php', $currentPage); ?>"
           id="studentNavProfile"
           title="Profile">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>

        <a href="../auth/change_password.php"
           class="<?php echo studentSidebarActive('change_password.php', $currentPage); ?>"
           id="studentNavChangePassword"
           title="Change Password">
            <i class="bi bi-key"></i>
            <span>Change Password</span>
        </a>

        <a href="../auth/logout.php"
           class="logout-link"
           id="studentNavLogout"
           title="Logout"
           onclick="return confirm('Are you sure you want to logout?');">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>

    </nav>

</div>

<!-- Main content wrapper — closed in each page before </body> -->
<div class="main-content" id="mainContent">