<?php
/**
 * ExamShield – Institute Management
 * File: institute/index.php
 * Desc: List all institutes — purple admin panel layout
 */
session_start();
require_once '../config/database.php';

// ── Flash messages ───────────────────────────────────────────────────────────
$flashSuccess = '';
$flashError   = '';
if (!empty($_SESSION['inst_success'])) { $flashSuccess = $_SESSION['inst_success']; unset($_SESSION['inst_success']); }
if (!empty($_SESSION['inst_error']))   { $flashError   = $_SESSION['inst_error'];   unset($_SESSION['inst_error']);   }

// ── Fetch ALL institutes ──────────────────────────────────────────────────────
$result     = mysqli_query($conn, "SELECT * FROM institute ORDER BY id DESC");
$institutes = [];
while ($row = mysqli_fetch_assoc($result)) { $institutes[] = $row; }

$total    = count($institutes);
$active   = count(array_filter($institutes, fn($r) => $r['status'] === 'Active'));
$inactive = $total - $active;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ExamShield – Institute Management">
    <title>Institutes | ExamShield</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/institute.css">
</head>
<body>

<!-- ── Top Navbar ─────────────────────────────────────────── -->
<nav class="es-navbar">
    <div class="nav-brand">
        <i class="fa-solid fa-shield-halved"></i>
        <span>ExamShield LPS</span>
    </div>
    <div class="nav-right">
        <button class="nav-bell" title="Notifications">
            <i class="fa-solid fa-bell"></i>
        </button>
        <div class="nav-user">
            <div class="nav-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <span class="nav-user-name">
                <?= htmlspecialchars($_SESSION['name'] ?? 'Admin') ?>
            </span>
        </div>
    </div>
</nav>

<!-- ── Sidebar ────────────────────────────────────────────── -->
<aside class="es-sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="logo-text">
            <h6>ExamShield LPS</h6>
            <span>Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <span class="nav-section-label">Main Menu</span>

        <a class="nav-item" href="#">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>
        <a class="nav-item active" href="index.php">
            <i class="fa-solid fa-building"></i> Institutes
        </a>
        <a class="nav-item" href="../department/index.php">
            <i class="fa-solid fa-layer-group"></i> Departments
        </a>

        <span class="nav-section-label">Other Modules</span>
        <a class="nav-item" href="#">
            <i class="fa-solid fa-users"></i> Users
        </a>
        <a class="nav-item" href="#">
            <i class="fa-solid fa-file-pen"></i> Exams
        </a>
        <a class="nav-item" href="#">
            <i class="fa-solid fa-chart-bar"></i> Reports
        </a>
        <a class="nav-item" href="#">
            <i class="fa-solid fa-bell"></i> Notifications
        </a>
        <a class="nav-item" href="#">
            <i class="fa-solid fa-gear"></i> Settings
        </a>
    </nav>

    <div class="sidebar-footer">
        <a class="nav-item" href="../app/auth/logout.php">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</aside>

<!-- ── Main Content ───────────────────────────────────────── -->
<main class="es-content">

    <!-- Breadcrumb -->
    <div class="es-breadcrumb">
        <a href="#"><i class="fa-solid fa-house"></i> Dashboard</a>
        <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></span>
        <span class="current">Institutes</span>
    </div>

    <!-- Flash -->
    <?php if ($flashSuccess): ?>
        <div class="es-flash es-flash-success">
            <i class="fa-solid fa-circle-check"></i>
            <?= htmlspecialchars($flashSuccess) ?>
        </div>
    <?php endif; ?>
    <?php if ($flashError): ?>
        <div class="es-flash es-flash-error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <?= htmlspecialchars($flashError) ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1>Institutes</h1>
            <p class="page-subtitle">Manage all institute profiles</p>
        </div>
        <a href="add.php" class="btn-purple">
            <i class="fa-solid fa-plus"></i> Add Institute
        </a>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-icon-purple"><i class="fa-solid fa-building"></i></div>
                <div class="stat-info">
                    <h6>Total Institutes</h6>
                    <div class="stat-number"><?= $total ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-icon-green"><i class="fa-solid fa-circle-check"></i></div>
                <div class="stat-info">
                    <h6>Active</h6>
                    <div class="stat-number"><?= $active ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon stat-icon-amber"><i class="fa-solid fa-circle-xmark"></i></div>
                <div class="stat-info">
                    <h6>Inactive</h6>
                    <div class="stat-number"><?= $inactive ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="es-card">
        <div class="es-card-header">
            <h5 class="es-card-title">
                <i class="fa-solid fa-table-list"></i> Institute List
            </h5>
            <div class="es-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="instSearch" placeholder="Search institute...">
            </div>
        </div>

        <div class="es-card-body">
            <?php if (empty($institutes)): ?>
            <div class="es-empty">
                <i class="fa-solid fa-building-circle-xmark"></i>
                <h5>No Institutes Found</h5>
                <p>Start by adding your first institute profile.</p>
                <a href="add.php" class="btn-purple">
                    <i class="fa-solid fa-plus"></i> Add Institute
                </a>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="es-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Institute Name</th>
                            <th>Code</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($institutes as $i => $inst): ?>
                        <tr class="inst-row">
                            <td class="text-muted"><?= $i + 1 ?></td>
                            <td class="cell-name"><?= htmlspecialchars($inst['institute_name']) ?></td>
                            <td><span class="code-pill"><?= htmlspecialchars($inst['institute_code']) ?></span></td>
                            <td><?= htmlspecialchars($inst['city'] ?? '—') ?></td>
                            <td>
                                <?php if ($inst['status'] === 'Active'): ?>
                                    <span class="badge-active">Active</span>
                                <?php else: ?>
                                    <span class="badge-inactive">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-icons">
                                    <a href="view.php?id=<?= (int)$inst['id'] ?>"
                                       class="btn-icon btn-icon-view"
                                       data-bs-toggle="tooltip" title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="edit.php?id=<?= (int)$inst['id'] ?>"
                                       class="btn-icon btn-icon-edit"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button
                                        class="btn-icon btn-icon-delete inst-delete-btn"
                                        data-id="<?= (int)$inst['id'] ?>"
                                        data-name="<?= htmlspecialchars($inst['institute_name']) ?>"
                                        data-bs-toggle="tooltip" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr id="instEmptySearch" style="display:none;">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-magnifying-glass fa-2x mb-2 d-block"></i>
                                No institutes match your search.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="es-pagination-wrap">
                <span class="es-pagination-info" id="instPageInfo"></span>
                <div class="es-pagination" id="instPagination"></div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/institute.js"></script>
<!-- Institute delete via SweetAlert -->
<script>
document.querySelectorAll('.inst-delete-btn').forEach(function(btn){
    btn.addEventListener('click',function(e){
        e.preventDefault();
        var id=this.getAttribute('data-id'), name=this.getAttribute('data-name')||'this institute';
        Swal.fire({title:'Delete Institute?',html:'You are about to delete <strong>'+name+'</strong>.<br>This cannot be undone.',
            icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',cancelButtonColor:'#6b7280',
            confirmButtonText:'<i class="fa-solid fa-trash"></i> Yes, Delete',cancelButtonText:'Cancel',reverseButtons:true
        }).then(function(result){
            if(result.isConfirmed){
                Swal.fire({title:'Deleting...',allowOutsideClick:false,showConfirmButton:false,didOpen:function(){Swal.showLoading();}});
                window.location.href='delete.php?id='+id;
            }
        });
    });
});
</script>
</body>
</html>