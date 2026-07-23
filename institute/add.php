<?php
/**
 * ExamShield – Institute Management
 * File: institute/add.php
 * Desc: Add a new institute — purple admin panel
 */
session_start();
require_once '../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Institute | ExamShield</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        <span class="current">Add Institute</span>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1>Add Institute</h1>
            <p class="page-subtitle">Register a new institute profile</p>
        </div>
        <a href="index.php" class="btn-light-action">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="es-form-card">
        <div class="es-form-header">
            <h5><i class="fa-solid fa-building-circle-arrow-right"></i> Institute Information</h5>
        </div>
        <div class="es-form-body">
            <form id="instituteForm" action="save.php" method="POST" novalidate>

                <div class="es-form-section"><i class="fa-solid fa-circle-info me-2"></i>Basic Information</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="instituteName">Institute Name <span class="req">*</span></label>
                        <input type="text" id="instituteName" name="institute_name" class="form-control"
                            placeholder="e.g. Greenfield College" maxlength="200" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="instituteCode">Code <span class="req">*</span></label>
                        <input type="text" id="instituteCode" name="institute_code" class="form-control"
                            placeholder="e.g. GFC001" maxlength="20" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="email">Email <span class="req">*</span></label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="info@institute.edu" maxlength="150" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="phone">Phone <span class="req">*</span></label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            placeholder="10-digit number" maxlength="15" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" for="website">Website <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="text" id="website" name="website" class="form-control"
                            placeholder="https://www.institute.edu" maxlength="200">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="status">Status <span class="req">*</span></label>
                        <select id="status" name="status" class="form-select">
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="es-form-section"><i class="fa-solid fa-location-dot me-2"></i>Address Details</div>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="address">Full Address <span class="req">*</span></label>
                        <textarea id="address" name="address" class="form-control"
                            placeholder="Street address, area, landmark..." rows="3" maxlength="500" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="city">City <span class="req">*</span></label>
                        <input type="text" id="city" name="city" class="form-control"
                            placeholder="e.g. Pune" maxlength="100" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="state">State <span class="req">*</span></label>
                        <input type="text" id="state" name="state" class="form-control"
                            placeholder="e.g. Maharashtra" maxlength="100" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="pincode">Pincode <span class="req">*</span></label>
                        <input type="text" id="pincode" name="pincode" class="form-control"
                            placeholder="6-digit pincode" maxlength="6" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="es-form-actions">
                    <button type="submit" class="btn-purple">
                        <i class="fa-solid fa-floppy-disk"></i> Save Institute
                    </button>
                    <a href="index.php" class="btn-light-action">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/institute.js"></script>
</body>
</html>