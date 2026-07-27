<?php
// views/edit_exam.php
// Expected variables: $exam, $success_msg, $error_msg
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Exam - ExamShield LPS</title>
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
                    <h5 class="card-title mb-0">Edit Exam Details</h5>
                </div>
                <div class="card-body">
                    <form id="formEditExam">
                        <input type="hidden" name="exam_id" value="<?php echo $exam['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Exam Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($exam['title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Marks (Cannot modify here)</label>
                            <input type="number" class="form-control" value="<?php echo $exam['total_marks']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Passing Marks</label>
                            <input type="number" name="passing_marks" class="form-control" value="<?php echo $exam['passing_marks']; ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Instructions</label>
                            <textarea name="instructions" class="form-control" rows="3"><?php echo htmlspecialchars($exam['instructions']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Details</button>
                        <a href="schedule_exam.php?id=<?php echo $exam['id']; ?>" class="btn btn-info w-100 mt-2 text-white">Edit Schedule</a>
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
