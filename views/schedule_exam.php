<?php
// views/schedule_exam.php
// Expected variables: $exam, $schedule, $success_msg, $error_msg
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Exam - ExamShield LPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><i class="fas fa-shield-alt"></i> ExamShield LPS</a>
        <div class="ms-auto">
            <a class="btn btn-outline-secondary" href="exam_list.php"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if($success_msg): ?>
                <div class="alert alert-success"><?php echo $success_msg; ?> Redirecting...</div>
            <?php endif; ?>
            <?php if($error_msg): ?>
                <div class="alert alert-danger"><?php echo $error_msg; ?></div>
            <?php endif; ?>

            <?php if($exam): ?>
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Schedule Exam: <?php echo htmlspecialchars($exam['title']); ?></h5>
                </div>
                <div class="card-body">
                    <form id="formScheduleExam">
                        <input type="hidden" name="exam_id" value="<?php echo $exam['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Exam Date</label>
                            <input type="date" name="exam_date" class="form-control" value="<?php echo $schedule['exam_date'] ?? ''; ?>" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Start Time</label>
                                <input type="time" name="start_time" id="startTime" class="form-control" value="<?php echo $schedule['start_time'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Time</label>
                                <input type="time" name="end_time" id="endTime" class="form-control" value="<?php echo $schedule['end_time'] ?? ''; ?>" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Duration (Minutes)</label>
                            <input type="number" name="duration" id="duration" class="form-control" value="<?php echo $schedule['duration'] ?? ''; ?>" readonly required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Schedule</button>
                    </form>
                </div>
            </div>
            <?php else: ?>
                <div class="alert alert-danger">Exam not found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/exam.js"></script>
</body>
</html>
