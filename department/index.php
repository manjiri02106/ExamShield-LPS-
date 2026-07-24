<?php
/**
 * ExamShield – Department Management
 * File: department/index.php
 * Desc: List all departments — purple admin panel layout
 */
session_start();
require_once '../config/database.php';

// Safe migration
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS dept_code VARCHAR(20) NOT NULL DEFAULT '' AFTER department_name");
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS hod VARCHAR(100) NOT NULL DEFAULT '' AFTER dept_code");
@mysqli_query($conn, "ALTER TABLE department ADD COLUMN IF NOT EXISTS institute_id INT DEFAULT NULL AFTER hod");

$flashSuccess = '';
$flashError   = '';
if (!empty($_SESSION['dept_success'])) { $flashSuccess = $_SESSION['dept_success']; unset($_SESSION['dept_success']); }
if (!empty($_SESSION['dept_error']))   { $flashError   = $_SESSION['dept_error'];   unset($_SESSION['dept_error']);   }

// Fetch all departments with institute name
$sql = "SELECT d.*, i.institute_name
        FROM department d
        LEFT JOIN institute i ON d.institute_id = i.id
        ORDER BY d.id DESC";
$result = mysqli_query($conn, $sql);
$depts = [];
while ($row = mysqli_fetch_assoc($result)) { $depts[] = $row; }

$total    = count($depts);
$active   = count(array_filter($depts, fn($d) => $d['status'] === 'Active'));
$inactive = $total - $active;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ExamShield – Department Management">
    <title>Departments | ExamShield</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/department.css">
</head>
<body>

<!-- Navbar -->
<nav class="es-navbar">
    <div class="nav-brand"><i class="fa-solid fa-shield-halved"></i><span>ExamShield LPS</span></div>
    <div class="nav-right">
        <button class="nav-bell"><i class="fa-solid fa-bell"></i></button>
        <div class="nav-user">
            <div class="nav-avatar"><i class="fa-solid fa-user"></i></div>
            <span class="nav-user-name"><?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?></span>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<aside class="es-sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="logo-text"><h6>ExamShield LPS</h6><span>Admin Panel</span></div>
    </div>
    <nav class="sidebar-nav">
        <span class="nav-section-label">Main Menu</span>
        <a class="nav-item" href="#"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
        <a class="nav-item" href="../institute/index.php"><i class="fa-solid fa-building"></i> Institutes</a>
        <a class="nav-item active" href="index.php"><i class="fa-solid fa-layer-group"></i> Departments</a>
        <span class="nav-section-label">Other Modules</span>
        <a class="nav-item" href="#"><i class="fa-solid fa-users"></i> Users</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-file-pen"></i> Exams</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-chart-bar"></i> Reports</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-bell"></i> Notifications</a>
        <a class="nav-item" href="#"><i class="fa-solid fa-gear"></i> Settings</a>
    </nav>
    <div class="sidebar-footer">
        <a class="nav-item" href="../app/auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>

<!-- Main Content -->
<main class="es-content">

    <div class="es-breadcrumb">
        <a href="#"><i class="fa-solid fa-house"></i> Dashboard</a>
        <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></span>
        <span class="current">Departments</span>
    </div>

    <?php if ($flashSuccess): ?>
        <div class="es-flash es-flash-success"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="es-flash es-flash-error"><i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1>Departments</h1>
            <p class="page-subtitle">Manage all departments across institutes</p>
        </div>
        <a href="add.php" class="btn-purple"><i class="fa-solid fa-plus"></i> Add Department</a>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-icon-purple"><i class="fa-solid fa-layer-group"></i></div>
                <div class="stat-info"><h6>Total Departments</h6><div class="stat-number"><?= $total ?></div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-icon-green"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-info"><h6>Active</h6><div class="stat-number"><?= $active ?></div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-icon-amber"><i class="fa-solid fa-circle-xmark"></i></div>
                <div class="stat-info"><h6>Inactive</h6><div class="stat-number"><?= $inactive ?></div></div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="es-card">
        <div class="es-card-header">
            <h5 class="es-card-title"><i class="fa-solid fa-table-list"></i> Department List</h5>
            <div class="es-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="deptSearch" placeholder="Search department...">
            </div>
        </div>
        <div class="es-card-body">
            <?php if (empty($depts)): ?>
            <div class="es-empty">
                <i class="fa-solid fa-layer-group"></i>
                <h5>No Departments Found</h5>
                <p>Start by adding your first department.</p>
                <a href="add.php" class="btn-purple"><i class="fa-solid fa-plus"></i> Add Department</a>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="es-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Department Name</th>
                            <th>Institute</th>
                            <th>HOD</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($depts as $i => $d): ?>
                        <tr class="dept-row">
                            <td class="text-muted"><?= $i + 1 ?></td>
                            <td class="cell-name">
                                <?= htmlspecialchars($d['department_name']) ?>
                                <?php if (!empty($d['dept_code'])): ?>
                                    <br><span class="code-pill" style="font-size:11px;margin-top:3px;display:inline-block;"><?= htmlspecialchars($d['dept_code']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= !empty($d['institute_name']) ? htmlspecialchars($d['institute_name']) : '<span class="text-muted">—</span>' ?></td>
                            <td><?= !empty($d['hod']) ? htmlspecialchars($d['hod']) : '<span class="text-muted">—</span>' ?></td>
                            <td>
                                <?php if ($d['status'] === 'Active'): ?>
                                    <span class="badge-active">Active</span>
                                <?php else: ?>
                                    <span class="badge-inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-icons">
                                    <a href="view.php?id=<?= (int)$d['id'] ?>" class="btn-icon btn-icon-view" title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="edit.php?id=<?= (int)$d['id'] ?>" class="btn-icon btn-icon-edit" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button class="btn-icon btn-icon-delete dept-delete-btn"
                                        data-id="<?= (int)$d['id'] ?>"
                                        data-name="<?= htmlspecialchars($d['department_name']) ?>" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr id="deptEmptySearch" style="display:none;">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-magnifying-glass fa-2x mb-2 d-block"></i>
                                No departments match your search.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="es-pagination-wrap">
                <span class="es-pagination-info" id="deptPageInfo"></span>
                <div class="es-pagination" id="deptPagination"></div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/department.js"></script>
</body>
</html>