<?php
/**
 * ==========================================
 * ExamShield LPS
 * Navbar
 * ==========================================
 */

if (!isset($pageTitle)) {
    $pageTitle = "Dashboard";
}

$userName = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">

    <div class="container-fluid">

        <!-- Mobile Menu Button -->
        <button class="btn btn-primary d-lg-none" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Page Title -->
        <h4 class="ms-3 mb-0 text-primary fw-bold">
            <?php echo $pageTitle; ?>
        </h4>

        <!-- Right Side -->
        <div class="ms-auto d-flex align-items-center">

            <!-- Search -->
            <div class="me-3">
                <input type="text"
                       id="searchBox"
                       class="form-control"
                       placeholder="Search...">
            </div>

            <!-- Notification -->
            <div class="dropdown me-3">

                <button class="btn btn-light position-relative"
                        data-bs-toggle="dropdown">

                    <i class="fas fa-bell"></i>

                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                    </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="#">
                            New Result Generated
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            Attendance Updated
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            New Exam Scheduled
                        </a>
                    </li>

                </ul>

            </div>

            <!-- User Menu -->
            <div class="dropdown">

                <button class="btn btn-light dropdown-toggle"
                        data-bs-toggle="dropdown">

                    <i class="fas fa-user-circle"></i>

                    <?php echo htmlspecialchars($userName); ?>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user"></i>
                            Profile
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog"></i>
                            Settings
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item text-danger"
                           href="<?php echo BASE_URL; ?>logout.php"
                           onclick="return confirmLogout();">

                            <i class="fas fa-sign-out-alt"></i>
                            Logout

                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>