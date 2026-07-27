<?php
// views/exam_list.php
// Expected variables: $exams
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams - ExamShield LPS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="exam_list.php">Exams</a>
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
        <h2><i class="fas fa-list text-primary"></i> Exam List</h2>
        <a href="create_exam.php" class="btn btn-primary"><i class="fas fa-plus"></i> Create Exam</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="examTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Exam Name</th>
                            <th>Subject</th>
                            <th>Questions</th>
                            <th>Duration (Mins)</th>
                            <th>Exam Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($exams as $exam): ?>
                        <tr>
                            <td class="fw-bold"><?php echo htmlspecialchars($exam['title']); ?></td>
                            <td><?php echo htmlspecialchars($exam['subject_name']); ?></td>
                            <td><span class="badge bg-secondary"><?php echo $exam['total_questions']; ?></span></td>
                            <td><?php echo $exam['duration'] ? htmlspecialchars($exam['duration']) : '-'; ?></td>
                            <td><?php echo $exam['exam_date'] ? date('d M Y', strtotime($exam['exam_date'])) : 'Not Set'; ?></td>
                            <td>
                                <?php 
                                    $statusClass = 'badge-draft';
                                    if($exam['status'] == 'Scheduled') $statusClass = 'badge-scheduled';
                                    if($exam['status'] == 'Published') $statusClass = 'badge-published';
                                ?>
                                <span class="badge <?php echo $statusClass; ?>"><?php echo $exam['status']; ?></span>
                            </td>
                            <td>
                                <a href="exam_details.php?id=<?php echo $exam['id']; ?>" class="btn btn-sm btn-info text-white" title="View"><i class="fas fa-eye"></i></a>
                                <a href="edit_exam.php?id=<?php echo $exam['id']; ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="fas fa-edit"></i></a>
                                <?php if($exam['status'] != 'Published'): ?>
                                    <button class="btn btn-sm btn-success" title="Publish" onclick="togglePublishStatus(<?php echo $exam['id']; ?>, '<?php echo $exam['status']; ?>')"><i class="fas fa-upload"></i></button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" title="Unpublish" onclick="togglePublishStatus(<?php echo $exam['id']; ?>, '<?php echo $exam['status']; ?>')"><i class="fas fa-download"></i></button>
                                <?php endif; ?>
                                <button class="btn btn-sm btn-danger" title="Delete" onclick="deleteExam(<?php echo $exam['id']; ?>)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/exam.js"></script>
<script>
function deleteExam(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to delete_exam.php
            fetch('backend/api/delete_exam.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to delete exam.', 'error');
            });
        }
    })
}
</script>
</body>
</html>
