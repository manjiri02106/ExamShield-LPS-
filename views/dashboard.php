<?php
// views/dashboard.php
// Expected variables: $stats array with total, published, scheduled, draft counts.
$totalExams = $stats['total'] ?? 0;
$publishedExams = $stats['published'] ?? 0;
$scheduledExams = $stats['scheduled'] ?? 0;
$draftExams = $stats['draft'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ExamShield LPS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><i class="fas fa-shield-alt"></i> ExamShield LPS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="exam_list.php">Exams</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary ms-3" href="create_exam.php">Create New Exam</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-tachometer-alt text-primary"></i> Admin Dashboard</h2>
    </div>

    <!-- Dashboard Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Total Exams</h6>
                        <h3 class="mb-0"><?php echo $totalExams; ?></h3>
                    </div>
                    <i class="fas fa-file-alt stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card" style="border-left-color: #28a745;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Published</h6>
                        <h3 class="mb-0 text-success"><?php echo $publishedExams; ?></h3>
                    </div>
                    <i class="fas fa-check-circle stat-icon text-success opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card" style="border-left-color: #17a2b8;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Scheduled</h6>
                        <h3 class="mb-0 text-info"><?php echo $scheduledExams; ?></h3>
                    </div>
                    <i class="fas fa-calendar-alt stat-icon text-info opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card" style="border-left-color: #6c757d;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Drafts</h6>
                        <h3 class="mb-0 text-secondary"><?php echo $draftExams; ?></h3>
                    </div>
                    <i class="fas fa-pencil-ruler stat-icon text-secondary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="create_exam.php" class="btn btn-outline-primary me-2"><i class="fas fa-plus"></i> Generate Test</a>
                    <a href="exam_list.php" class="btn btn-outline-secondary"><i class="fas fa-list"></i> View All Exams</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
