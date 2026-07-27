<?php
/**
 * ==========================================
 * ExamShield LPS - Result Management Header
 * ==========================================
 */

require_once(__DIR__ . '/database.php');

$pageTitle = isset($pageTitle) ? $pageTitle : "Student Result Management & Reports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="app-container">

    <!-- Left Sidebar (#1E3A5F) -->
    <?php include(__DIR__ . '/sidebar.php'); ?>

    <!-- Main Content Area -->
    <div class="main-layout">

        <!-- Top Sticky Header Bar (60px) -->
        <header class="top-sticky-header">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm text-dark d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars fs-5"></i>
                </button>
                <div class="header-title-box">
                    <h1>Student Result Management & Reports</h1>
                    <span>ExamShield LPS Admin System</span>
                </div>
            </div>

            <div class="header-actions">
                <!-- Search Box -->
                <div class="search-input-group d-none d-md-block">
                    <input type="text" class="form-control" placeholder="Search student or exam...">
                </div>

                <!-- Notification Icon -->
                <a href="#" class="position-relative text-dark fs-5" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle"></span>
                </a>

                <!-- User Profile -->
                <div class="header-user-profile">
                    <div class="user-avatar">A</div>
                    <div class="d-none d-sm-block">
                        <div class="fw-bold small text-dark lh-1">Admin User</div>
                        <span class="text-muted" style="font-size: 0.7rem;">System Admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content Wrapper (ZERO whitespace above content) -->
        <main class="page-content-wrapper">
