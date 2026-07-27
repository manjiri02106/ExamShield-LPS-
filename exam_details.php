<?php
// exam_details.php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: exam_list.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch exam details
$stmt = $pdo->prepare("
    SELECT e.*, d.name as department_name, s.name as subject_name 
    FROM exam_master e
    JOIN departments d ON e.department_id = d.id
    JOIN subjects s ON e.subject_id = s.id
    WHERE e.id = ?
");
$stmt->execute([$id]);
$exam = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$exam) {
    die("Exam not found.");
}

// Fetch schedule
$sStmt = $pdo->prepare("SELECT * FROM exam_schedule WHERE exam_id = ?");
$sStmt->execute([$id]);
$schedule = $sStmt->fetch(PDO::FETCH_ASSOC);

// Fetch questions
$qStmt = $pdo->prepare("
    SELECT q.* 
    FROM exam_questions eq
    JOIN question_bank q ON eq.question_id = q.id
    WHERE eq.exam_id = ?
");
$qStmt->execute([$id]);
$questions = $qStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Details - ExamShield LPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><i class="fas fa-shield-alt"></i> ExamShield LPS</a>
        <div class="ms-auto">
            <a class="btn btn-outline-secondary" href="exam_list.php"><i class="fas fa-arrow-left"></i> Back to Exams</a>
            <a class="btn btn-warning ms-2 text-white" href="edit_exam.php?id=<?php echo $id; ?>"><i class="fas fa-edit"></i> Edit</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <!-- Exam Info -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Exam Information</h5>
                    <span class="badge bg-<?php echo ($exam['status']=='Published') ? 'success' : (($exam['status']=='Scheduled') ? 'info' : 'secondary'); ?>"><?php echo $exam['status']; ?></span>
                </div>
                <div class="card-body">
                    <h3 class="text-primary mb-3"><?php echo htmlspecialchars($exam['title']); ?></h3>
                    <div class="row mb-3">
                        <div class="col-sm-6"><strong>Department:</strong> <?php echo htmlspecialchars($exam['department_name']); ?></div>
                        <div class="col-sm-6"><strong>Subject:</strong> <?php echo htmlspecialchars($exam['subject_name']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Semester:</strong> <?php echo $exam['semester']; ?></div>
                        <div class="col-sm-4"><strong>Year:</strong> <?php echo $exam['year']; ?></div>
                        <div class="col-sm-4"><strong>Type:</strong> <?php echo htmlspecialchars($exam['exam_type']); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6"><strong>Total Marks:</strong> <?php echo $exam['total_marks']; ?></div>
                        <div class="col-sm-6"><strong>Passing Marks:</strong> <?php echo $exam['passing_marks']; ?></div>
                    </div>
                    <div class="mb-0">
                        <strong>Instructions:</strong>
                        <p class="text-muted mt-1 bg-light p-3 rounded border"><?php echo nl2br(htmlspecialchars($exam['instructions'])); ?></p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Questions (<?php echo count($questions); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php foreach($questions as $index => $q): ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">Q<?php echo $index + 1; ?>. <?php echo htmlspecialchars($q['question_text']); ?></h6>
                                    <small class="badge bg-primary rounded-pill"><?php echo $q['marks']; ?> M</small>
                                </div>
                                <small class="text-muted">Type: <?php echo $q['type']; ?> | Difficulty: <?php echo $q['difficulty']; ?> | Unit: <?php echo $q['unit']; ?></small>
                            </div>
                        <?php endforeach; ?>
                        <?php if(count($questions) == 0): ?>
                            <p class="text-muted">No questions added to this exam.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Info -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0"><i class="fas fa-calendar-alt text-primary"></i> Schedule Details</h5>
                </div>
                <div class="card-body">
                    <?php if($schedule): ?>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <span class="text-muted d-block small">Date</span>
                                <strong class="fs-5"><?php echo date('d M Y', strtotime($schedule['exam_date'])); ?></strong>
                            </li>
                            <li class="mb-3">
                                <span class="text-muted d-block small">Timing</span>
                                <strong><?php echo date('h:i A', strtotime($schedule['start_time'])); ?> - <?php echo date('h:i A', strtotime($schedule['end_time'])); ?></strong>
                            </li>
                            <li>
                                <span class="text-muted d-block small">Duration</span>
                                <strong><?php echo $schedule['duration']; ?> Minutes</strong>
                            </li>
                        </ul>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0">Not Scheduled Yet.</div>
                    <?php endif; ?>
                    <a href="schedule_exam.php?id=<?php echo $id; ?>" class="btn btn-outline-primary btn-sm mt-3 w-100">Update Schedule</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
