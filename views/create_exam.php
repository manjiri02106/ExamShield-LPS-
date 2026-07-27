<?php
// views/create_exam.php
// Expected variables: $departments, $subjects, $success_msg, $error_msg
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam - ExamShield LPS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php"><i class="fas fa-shield-alt"></i> ExamShield LPS</a>
        <div class="ms-auto">
            <a class="btn btn-outline-secondary" href="exam_list.php"><i class="fas fa-arrow-left"></i> Back to Exams</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php if($success_msg): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success_msg; ?> Redirecting...</div>
    <?php endif; ?>
    <?php if($error_msg): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $error_msg; ?></div>
    <?php endif; ?>

    <form action="" method="POST" id="formCreateExam">
        <div class="row">
            <!-- LEFT PANEL: Create Exam -->
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title"><i class="fas fa-file-signature text-primary"></i> 1. Exam Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Exam Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Mid-Term Examination 2026">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Department <span class="text-danger">*</span></label>
                                <select name="department_id" class="form-select" required>
                                    <option value="">Select Department</option>
                                    <?php foreach($departments as $dept): ?>
                                        <option value="<?php echo $dept['id']; ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                <select name="subject_id" id="subject" class="form-select" required onchange="loadQuestionBank()">
                                    <option value="">Select Subject</option>
                                    <?php foreach($subjects as $sub): ?>
                                        <option value="<?php echo $sub['id']; ?>"><?php echo htmlspecialchars($sub['name']); ?> (<?php echo htmlspecialchars($sub['code']); ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Semester</label>
                                <input type="number" name="semester" class="form-control" min="1" max="8" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Year</label>
                                <input type="number" name="year" class="form-control" min="2020" max="2100" value="<?php echo date('Y'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Exam Type</label>
                                <select name="exam_type" class="form-select" required>
                                    <option value="Internal">Internal</option>
                                    <option value="External">External</option>
                                    <option value="Practical">Practical</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Total Marks</label>
                                <input type="number" name="total_marks" id="total_marks" class="form-control" readonly value="0">
                                <small class="text-muted">Calculated from selected questions</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Passing Marks <span class="text-danger">*</span></label>
                                <input type="number" name="passing_marks" class="form-control" required min="1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Instructions</label>
                            <textarea name="instructions" class="form-control" rows="3" placeholder="Enter instructions for students..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-list-ul text-primary"></i> 2. Select Questions</h5>
                        <select id="qSelectionType" class="form-select form-select-sm w-auto">
                            <option value="manual">Manual Selection</option>
                            <option value="random">Random Generator</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <!-- Manual Selection -->
                        <div id="manualSelectionDiv">
                            <div class="alert alert-info py-2"><i class="fas fa-info-circle"></i> Select a subject above to load questions.</div>
                            <div id="questionBankContainer" style="max-height: 400px; overflow-y: auto;">
                                <!-- Loaded via AJAX from question_bank.php -->
                            </div>
                        </div>

                        <!-- Random Generator -->
                        <div id="randomSelectionDiv" class="d-none">
                            <p class="text-muted">Specify the number of questions for each difficulty level.</p>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Easy</label>
                                    <input type="number" id="easyCount" class="form-control" min="0" value="0">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Medium</label>
                                    <input type="number" id="mediumCount" class="form-control" min="0" value="0">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Hard</label>
                                    <input type="number" id="hardCount" class="form-control" min="0" value="0">
                                </div>
                            </div>
                            <button type="button" id="btnGenerateRandom" class="btn btn-primary btn-sm"><i class="fas fa-random"></i> Generate Questions</button>
                        </div>

                        <hr>
                        <h6 class="fw-bold mt-3">Selected Questions: <span id="selectedCountBadge" class="badge bg-primary">0</span></h6>
                        <div id="selectedQuestionsList" class="mt-2 text-muted">
                            No questions selected yet.
                        </div>
                        <input type="hidden" id="finalTotalMarks" name="final_total_marks" value="0">
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-4 d-md-none">
                     <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                     <button type="button" class="btn btn-primary" onclick="window.scrollTo(0, document.body.scrollHeight);">Next <i class="fas fa-arrow-down"></i></button>
                </div>
            </div>

            <!-- RIGHT PANEL: Schedule Exam -->
            <div class="col-md-5">
                <div class="card mb-4" style="position: sticky; top: 20px;">
                    <div class="card-header bg-white">
                        <h5 class="card-title"><i class="fas fa-calendar-check text-primary"></i> 3. Schedule & Publish</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Exam Date</label>
                            <input type="date" name="exam_date" class="form-control">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Start Time</label>
                                <input type="time" name="start_time" id="startTime" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">End Time</label>
                                <input type="time" name="end_time" id="endTime" class="form-control">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Duration (Minutes)</label>
                            <input type="number" name="duration" id="duration" class="form-control" readonly placeholder="Auto-calculated">
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" id="publishToggle" name="publish_exam">
                            <label class="form-check-label fw-bold text-success" for="publishToggle">Publish Immediately</label>
                            <div class="form-text">If checked, students will be able to see the exam right away.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="save_draft" class="btn btn-outline-secondary">Save as Draft</button>
                            <button type="submit" name="schedule_exam_btn" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save & Schedule Exam</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/exam.js"></script>
<script>
// Logic to handle question selection marks calculation
document.addEventListener('click', function(e) {
    if(e.target && e.target.classList.contains('q-checkbox')) {
        recalculateTotalMarks();
    }
});

function recalculateTotalMarks() {
    let total = 0;
    let count = 0;
    const selectedQuestionsContainer = document.getElementById('selectedQuestionsList');
    selectedQuestionsContainer.innerHTML = '';
    let ul = document.createElement('ul');
    ul.className = 'list-group';

    document.querySelectorAll('.q-checkbox:checked').forEach(function(checkbox) {
        total += parseInt(checkbox.dataset.marks);
        count++;
        
        let li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center py-1';
        li.innerHTML = `
            <span class="text-truncate d-inline-block" style="max-width: 80%; font-size: 0.85rem;">${checkbox.dataset.text}</span>
            <span class="badge bg-primary rounded-pill">${checkbox.dataset.marks} M</span>
            <input type="hidden" name="question_ids[]" value="${checkbox.value}">
        `;
        ul.appendChild(li);
    });

    if(count === 0) {
        selectedQuestionsContainer.innerHTML = '<span class="text-muted">No questions selected yet.</span>';
    } else {
        selectedQuestionsContainer.appendChild(ul);
    }

    document.getElementById('total_marks').value = total;
    document.getElementById('selectedCountBadge').innerText = count;
}
</script>
</body>
</html>
