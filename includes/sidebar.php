<?php
/**
 * ==========================================
 * ExamShield LPS
 * Sidebar
 * ==========================================
 */
?>

<div class="sidebar" id="sidebar">

    <!-- Logo -->
    <div class="text-center mb-4">
        <h2 class="text-white">ExamShield</h2>
        <small class="text-light">LPS v1.0</small>
    </div>

    <hr class="text-light">

    <ul class="nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>index.php" class="nav-link text-white">
                <i class="fas fa-home me-2"></i>
                Dashboard
            </a>
        </li>

        <!-- Automatic Evaluation -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>modules/automatic_evaluation/index.php" class="nav-link text-white">
                <i class="fas fa-check-circle me-2"></i>
                Automatic Evaluation
            </a>
        </li>

        <!-- Result Generation -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>modules/result_generation/index.php" class="nav-link text-white">
                <i class="fas fa-file-alt me-2"></i>
                Result Generation
            </a>
        </li>

        <!-- Student Result Management & Reports Module -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>result-management/dashboard.php" class="nav-link text-white bg-primary bg-opacity-25 rounded fw-semibold">
                <i class="fas fa-graduation-cap me-2 text-warning"></i>
                Result Management & Reports
            </a>
        </li>

        <!-- Marks -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>modules/marks/index.php" class="nav-link text-white">
                <i class="fas fa-book me-2"></i>
                Marks
            </a>
        </li>

        <!-- Attendance -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>modules/attendance/index.php" class="nav-link text-white">
                <i class="fas fa-calendar-check me-2"></i>
                Attendance Report
            </a>
        </li>

        <!-- Department Reports -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>modules/department_reports/index.php" class="nav-link text-white">
                <i class="fas fa-building me-2"></i>
                Department Reports
            </a>
        </li>

        <!-- Analytics Dashboard -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>modules/analytics/index.php" class="nav-link text-white">
                <i class="fas fa-chart-line me-2"></i>
                Analytics Dashboard
            </a>
        </li>

        <hr class="text-light">

        <!-- Settings -->
        <li class="nav-item">
            <a href="#" class="nav-link text-white">
                <i class="fas fa-cog me-2"></i>
                Settings
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a href="<?php echo BASE_URL; ?>logout.php"
               class="nav-link text-danger"
               onclick="return confirmLogout();">

                <i class="fas fa-sign-out-alt me-2"></i>
                Logout

            </a>
        </li>

    </ul>

</div>