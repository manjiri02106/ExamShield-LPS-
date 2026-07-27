<?php
/**
 * ExamShield – Institute Management
 * File: institute/view.php
 * Desc: View a single institute's full details
 */
session_start();
require_once '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php'); exit();
}
$id   = (int) $_GET['id'];
$stmt = mysqli_prepare($conn, 'SELECT * FROM institute WHERE id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$inst = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$inst) { header('Location: index.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($inst['institute_name']) ?> | ExamShield</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/institute.css">
</head>
<body>

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

<aside class="es-sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="logo-text"><h6>ExamShield LPS</h6><span>Admin Panel</span></div>
    </div>
    <nav class="sidebar-nav">
        <span class="nav-section-label">Main Menu</span>
        <a class="nav-item" href="#"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
        <a class="nav-item active" href="index.php"><i class="fa-solid fa-building"></i> Institutes</a>
        <a class="nav-item" href="../department/index.php"><i class="fa-solid fa-layer-group"></i> Departments</a>
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

<main class="es-content">
    <!-- Breadcrumb -->
    <div class="es-breadcrumb">
        <a href="#"><i class="fa-solid fa-house"></i> Dashboard</a>
        <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></span>
        <a href="index.php">Institutes</a>
        <span class="sep"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></span>
        <span class="current"><?= htmlspecialchars($inst['institute_name']) ?></span>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1>Institute Details</h1>
            <p class="page-subtitle">Full profile of this institute</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="edit.php?id=<?= $id ?>" class="btn-purple">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            <a href="index.php" class="btn-light-action">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Detail Header Card -->
    <div class="detail-header-card">
        <div class="detail-icon-box"><i class="fa-solid fa-building"></i></div>
        <div class="detail-header-text">
            <h4><?= htmlspecialchars($inst['institute_name']) ?></h4>
            <p>
                <span class="code-pill" style="background:rgba(255,255,255,.22);color:white;">
                    <?= htmlspecialchars($inst['institute_code']) ?>
                </span>
                &nbsp;
                <?php if ($inst['status'] === 'Active'): ?>
                    <span class="badge-active" style="background:rgba(16,185,129,.25);color:#a7f3d0;">Active</span>
                <?php else: ?>
                    <span class="badge-inactive" style="background:rgba(245,158,11,.25);color:#fde68a;">Inactive</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Info Table -->
    <div class="es-card">
        <div class="es-card-header">
            <h5 class="es-card-title"><i class="fa-solid fa-circle-info"></i> Institute Information</h5>
            <div class="action-icons">
                <a href="edit.php?id=<?= $id ?>" class="btn-icon btn-icon-edit" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <button class="btn-icon btn-icon-delete inst-delete-btn"
                    data-id="<?= $id ?>"
                    data-name="<?= htmlspecialchars($inst['institute_name']) ?>" title="Delete">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="es-card-body">
            <table class="detail-info-table">
                <tr>
                    <th><i class="fa-solid fa-building"></i> Institute Name</th>
                    <td><strong><?= htmlspecialchars($inst['institute_name']) ?></strong></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-hashtag"></i> Institute Code</th>
                    <td><span class="code-pill"><?= htmlspecialchars($inst['institute_code']) ?></span></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-envelope"></i> Email</th>
                    <td><a href="mailto:<?= htmlspecialchars($inst['email']) ?>" style="color:var(--primary);"><?= htmlspecialchars($inst['email']) ?></a></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-phone"></i> Phone</th>
                    <td><?= htmlspecialchars($inst['phone']) ?></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-globe"></i> Website</th>
                    <td>
                        <?php if (!empty($inst['website'])): ?>
                            <a href="<?= htmlspecialchars($inst['website']) ?>" target="_blank" style="color:var(--primary);">
                                <?= htmlspecialchars($inst['website']) ?> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:11px;"></i>
                            </a>
                        <?php else: echo '—'; endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-location-dot"></i> Address</th>
                    <td><?= htmlspecialchars($inst['address']) ?></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-city"></i> City</th>
                    <td><?= htmlspecialchars($inst['city']) ?></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-map"></i> State</th>
                    <td><?= htmlspecialchars($inst['state']) ?></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-mailbox"></i> Pincode</th>
                    <td><?= htmlspecialchars($inst['pincode']) ?></td>
                </tr>
                <tr>
                    <th><i class="fa-solid fa-toggle-on"></i> Status</th>
                    <td>
                        <?php if ($inst['status'] === 'Active'): ?>
                            <span class="badge-active">Active</span>
                        <?php else: ?>
                            <span class="badge-inactive">Inactive</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="d-flex gap-2 mt-3 flex-wrap">
        <a href="edit.php?id=<?= $id ?>" class="btn-purple"><i class="fa-solid fa-pen-to-square"></i> Edit Profile</a>
        <a href="../department/index.php" class="btn-light-action"><i class="fa-solid fa-layer-group"></i> Manage Departments</a>
        <a href="index.php" class="btn-light-action"><i class="fa-solid fa-list"></i> All Institutes</a>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script>
document.querySelectorAll('.inst-delete-btn').forEach(function(btn){
    btn.addEventListener('click',function(e){
        e.preventDefault();
        var id=this.getAttribute('data-id'),name=this.getAttribute('data-name');
        Swal.fire({title:'Delete Institute?',html:'You are about to delete <strong>'+name+'</strong>.',
            icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',cancelButtonColor:'#6b7280',
            confirmButtonText:'<i class="fa-solid fa-trash"></i> Yes, Delete',cancelButtonText:'Cancel',reverseButtons:true
        }).then(function(r){ if(r.isConfirmed) window.location.href='delete.php?id='+id; });
    });
});
</script>
</body>
</html>
