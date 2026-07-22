<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only ADMIN can access this page
checkRole("ADMIN");

// Fetch departments
$sql = "SELECT id, department_name
        FROM departments
        ORDER BY department_name ASC";

$result = $conn->query($sql);

require_once "../includes/header.php";
require_once "../includes/navbar.php";
require_once "../includes/sidebar.php";

?>

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-8 mx-auto">

            <div class="card shadow">

                <div class="card-header">

                    <h3 class="mb-0">
                        Create Faculty
                    </h3>

                </div>

                <div class="card-body">

                    <form
                        action="create_faculty_process.php"
                        method="POST"
                    >

                        <div class="mb-3">

                            <label class="form-label">

                                Faculty Name

                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Default Password

                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Department

                            </label>

                            <select
                                name="department_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select Department
                                </option>

                                <?php while ($department = $result->fetch_assoc()) { ?>

                                    <option value="<?php echo $department['id']; ?>">

                                        <?php echo htmlspecialchars($department['department_name']); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-person-plus-fill"></i>

                            Create Faculty

                        </button>

                        <a
                            href="../dashboard/admin.php"
                            class="btn btn-secondary"
                        >

                            Back

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

require_once "../includes/footer.php";

?>