<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">

    <div class="container-fluid">

        <a
            class="navbar-brand fw-bold"
            href="../dashboard/super_admin.php">

            <i class="bi bi-shield-lock-fill"></i>

            ExamShield

        </a>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">

                <i class="bi bi-person-circle"></i>

                <?php

                if (isset($_SESSION['name'])) {

                    echo htmlspecialchars($_SESSION['name']);

                }

                ?>

            </span>

            <span class="badge bg-primary">

                <?php

                if (isset($_SESSION['role'])) {

                    echo htmlspecialchars($_SESSION['role']);

                }

                ?>

            </span>

        </div>

    </div>

</nav>