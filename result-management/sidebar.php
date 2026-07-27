<?php
/**
 * ==========================================
 * ExamShield LPS - Result Management Left Sidebar
 * (#1E3A5F Dark Navy Blue)
 * ==========================================
 */

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar-nav-container" id="sidebar">
    <!-- Brand Header -->
    <div class="sidebar-brand">
        <i class="fas fa-shield-alt text-primary fs-4"></i>
        <h1 class="sidebar-brand-title">ExamShield LPS</h1>
    </div>

    <!-- Sidebar Navigation Menu -->
    <ul class="sidebar-menu">
        <li class="menu-item">
            <a href="dashboard.php" class="menu-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link" onclick="alert('Institutions management'); return false;">
                <i class="fas fa-university"></i>
                <span>Institutions</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="department_report.php" class="menu-link <?php echo ($currentPage == 'department_report.php') ? 'active' : ''; ?>">
                <i class="fas fa-building"></i>
                <span>Departments</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link" onclick="alert('Users directory'); return false;">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="generate_result.php" class="menu-link <?php echo ($currentPage == 'generate_result.php') ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i>
                <span>Exams</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="results.php" class="menu-link <?php echo in_array($currentPage, ['results.php', 'marksheet.php', 'topper_report.php', 'failed_students.php']) ? 'active' : ''; ?>">
                <i class="fas fa-chart-pie"></i>
                <span>Reports</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link" onclick="alert('Notifications panel'); return false;">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link" onclick="alert('System Settings'); return false;">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

    <div class="p-3 border-top border-secondary border-opacity-25 mt-auto">
        <a href="../logout.php" class="menu-link text-danger">
            <i class="fas fa-sign-out-alt"></i>
            <span>Sign Out</span>
        </a>
    </div>
</aside>
