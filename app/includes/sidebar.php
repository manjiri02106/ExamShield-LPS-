<div class="sidebar">

    <div class="sidebar-header">

        <h4>
            <i class="bi bi-shield-lock-fill"></i>
            ExamShield
        </h4>

        <small>Proctored Examination System</small>

    </div>

    <div class="sidebar-menu">

        <!-- =========================
             SUPER ADMIN
        ========================== -->

        <?php if ($_SESSION['role'] == 'SUPER_ADMIN') { ?>

            <div class="menu-title">
                MAIN
            </div>

            <a href="../dashboard/super_admin.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <div class="menu-title">
                USER MANAGEMENT
            </div>

            <a href="../users/create_admin.php">
                <i class="bi bi-person-plus-fill"></i>
                Create Admin
            </a>

            <a href="../users/view_admins.php">
                <i class="bi bi-people-fill"></i>
                View Admins
            </a>

        <?php } ?>



        <!-- =========================
             ADMIN
        ========================== -->

        <?php if ($_SESSION['role'] == 'ADMIN') { ?>

            <div class="menu-title">
                MAIN
            </div>

            <a href="../dashboard/admin.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <div class="menu-title">
                FACULTY MANAGEMENT
            </div>

            <a href="../users/create_faculty.php">
                <i class="bi bi-person-plus-fill"></i>
                Create Faculty
            </a>

            <a href="../users/view_faculty.php">
                <i class="bi bi-people-fill"></i>
                View Faculty
            </a>

        <?php } ?>



        <!-- =========================
             FACULTY
        ========================== -->

        <?php if ($_SESSION['role'] == 'FACULTY') { ?>

            <div class="menu-title">
                MAIN
            </div>

            <a href="../dashboard/faculty.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <div class="menu-title">
                STUDENT MANAGEMENT
            </div>

            <a href="../users/create_student.php">
                <i class="bi bi-person-plus-fill"></i>
                Create Student
            </a>

            <a href="../users/view_students.php">
                <i class="bi bi-people-fill"></i>
                View Students
            </a>

            <div class="menu-title">
                EXAM MANAGEMENT
            </div>

            <a href="#">
                <i class="bi bi-file-earmark-text-fill"></i>
                Question Bank
            </a>

            <a href="#">
                <i class="bi bi-calendar-event"></i>
                Schedule Exam
            </a>

            <a href="#">
                <i class="bi bi-clipboard-check"></i>
                Results
            </a>

        <?php } ?>



        <!-- =========================
             STUDENT
        ========================== -->

        <?php if ($_SESSION['role'] == 'STUDENT') { ?>

            <div class="menu-title">
                MAIN
            </div>

            <a href="../dashboard/student.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <div class="menu-title">
                EXAM
            </div>

            <a href="#">
                <i class="bi bi-pencil-square"></i>
                Take Exam
            </a>

            <a href="#">
                <i class="bi bi-award"></i>
                View Results
            </a>

        <?php } ?>



        <!-- =========================
             SYSTEM
        ========================== -->

        <div class="menu-title">
            SYSTEM
        </div>

        <a href="../auth/logout.php">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </a>

    </div>

</div>

<div class="content-wrapper">