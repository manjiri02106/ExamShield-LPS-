<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();


include("../config/database.php");
?>

<!DOCTYPE html>
<html>

<head>

<title>Question Bank</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-light">

<div class="container mt-4">

<div class="row">

<?php
if (isset($_GET['msg']) && $_GET['msg'] == "added") {
    echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Question added successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>';
}
?>

<!-- Filters + Search -->

<form method="GET">

<div class="row mb-3">

    <!-- Subject -->
    <div class="col-md-3">
        <select name="subject" class="form-select">
            <option value="">All Subjects</option>
            <option value="Python" <?php if(isset($_GET['subject']) && $_GET['subject']=="Python") echo "selected"; ?>>Python</option>
            <option value="Java" <?php if(isset($_GET['subject']) && $_GET['subject']=="Java") echo "selected"; ?>>Java</option>
            <option value="DBMS" <?php if(isset($_GET['subject']) && $_GET['subject']=="DBMS") echo "selected"; ?>>DBMS</option>
            <option value="CN" <?php if(isset($_GET['subject']) && $_GET['subject']=="CN") echo "selected"; ?>>CN</option>
        </select>
    </div>

    <!-- Category -->
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">All Categories</option>
            <option value="Theory" <?php if(isset($_GET['category']) && $_GET['category']=="Theory") echo "selected"; ?>>Theory</option>
            <option value="Programming" <?php if(isset($_GET['category']) && $_GET['category']=="Programming") echo "selected"; ?>>Programming</option>
            <option value="Numerical" <?php if(isset($_GET['category']) && $_GET['category']=="Numerical") echo "selected"; ?>>Numerical</option>
            <option value="Aptitude" <?php if(isset($_GET['category']) && $_GET['category']=="Aptitude") echo "selected"; ?>>Aptitude</option>
        </select>
    </div>

    <!-- Difficulty -->
    <div class="col-md-3">
        <select name="difficulty" class="form-select">
            <option value="">All Difficulty</option>
            <option value="Easy" <?php if(isset($_GET['difficulty']) && $_GET['difficulty']=="Easy") echo "selected"; ?>>Easy</option>
            <option value="Medium" <?php if(isset($_GET['difficulty']) && $_GET['difficulty']=="Medium") echo "selected"; ?>>Medium</option>
            <option value="Hard" <?php if(isset($_GET['difficulty']) && $_GET['difficulty']=="Hard") echo "selected"; ?>>Hard</option>
        </select>
    </div>

    <!-- Filter Button -->
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">
            <i class="fa-solid fa-filter"></i> Filter
        </button>
    </div>

</div>

<div class="row mb-3">

    <div class="col-md-3">
        <input type="text" name="search" class="form-control"
            placeholder="Search by ID, Question or Subject"
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-success w-100">
            <i class="fa-solid fa-search"></i> Search
        </button>
    </div>

    <div class="col-md-2">
        <a href="index.php" class="btn btn-secondary w-100">
            Reset
        </a>
    </div>

    <div class="col-md-2">
        <a href="#addQuestionForm" class="btn btn-primary w-100">
            <i class="fa-solid fa-plus"></i> Add Question
        </a>
    </div>

    <div class="col-md-2">
        <a href="import_questions.php" class="btn btn-success w-100">
            <i class="fa-solid fa-file-import"></i> Import CSV
        </a>
    </div>

    <div class="col-md-1">
        <a href="export_questions.php" class="btn btn-warning w-100">
            <i class="fa-solid fa-file-export"></i>
        </a>
    </div>

</div>
</div>
</div>

</form>

</div>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Question</th>

<th>Subject</th>

<th>Difficulty</th>

<th>Category</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php
// Pagination
$limit = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$start = ($page - 1) * $limit;
$where = [];

// Search
if (!empty($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $where[] = "(id LIKE '%$search%'
              OR question LIKE '%$search%'
              OR subject LIKE '%$search%')";
}

// Subject Filter
if (!empty($_GET['subject'])) {

    $subject = mysqli_real_escape_string($conn, $_GET['subject']);

    $where[] = "subject='$subject'";
}

// Category Filter
if (!empty($_GET['category'])) {

    $category = mysqli_real_escape_string($conn, $_GET['category']);

    $where[] = "category='$category'";
}

// Difficulty Filter
if (!empty($_GET['difficulty'])) {

    $difficulty = mysqli_real_escape_string($conn, $_GET['difficulty']);

    $where[] = "difficulty='$difficulty'";
}

$sql = "SELECT * FROM questions";

if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY id DESC LIMIT $start, $limit";

$result = mysqli_query($conn, $sql);
// Count total records for pagination
$count_sql = "SELECT COUNT(*) AS total FROM questions";

if (count($where) > 0) {
    $count_sql .= " WHERE " . implode(" AND ", $where);
}

$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);

$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['question']; ?></td>

<td><?php echo $row['subject']; ?></td>

<td><?php echo $row['difficulty']; ?></td>

<td><?php echo $row['category']; ?></td>

<td>

<a
href="view_question.php?id=<?php echo $row['id']; ?>"
class="btn btn-sm btn-info">

<i class="fa-solid fa-eye"></i>

</a>

<a
href="edit_question.php?id=<?php echo $row['id']; ?>"
class="btn btn-sm btn-warning">

<i class="fa-solid fa-pen"></i>

</a>

<a href="delete_question.php?id=<?php echo $row['id']; ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Are you sure you want to delete this question?');">

    <i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php

}

?>

</tbody>
<nav class="mt-3">
    <ul class="pagination justify-content-center">

        <!-- Previous -->
        <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
            <a class="page-link"
               href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>&subject=<?php echo urlencode($_GET['subject'] ?? ''); ?>&category=<?php echo urlencode($_GET['category'] ?? ''); ?>&difficulty=<?php echo urlencode($_GET['difficulty'] ?? ''); ?>">
                Previous
            </a>
        </li>

        <!-- Page Numbers -->
        <?php for($i = 1; $i <= $total_pages; $i++) { ?>

            <li class="page-item <?php if($page == $i) echo 'active'; ?>">
                <a class="page-link"
                   href="?page=<?php echo $i; ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>&subject=<?php echo urlencode($_GET['subject'] ?? ''); ?>&category=<?php echo urlencode($_GET['category'] ?? ''); ?>&difficulty=<?php echo urlencode($_GET['difficulty'] ?? ''); ?>">
                    <?php echo $i; ?>
                </a>
            </li>

        <?php } ?>

        <!-- Next -->
        <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
            <a class="page-link"
               href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>&subject=<?php echo urlencode($_GET['subject'] ?? ''); ?>&category=<?php echo urlencode($_GET['category'] ?? ''); ?>&difficulty=<?php echo urlencode($_GET['difficulty'] ?? ''); ?>">
                Next
            </a>
        </li>

    </ul>
</nav>
</table>

</div>

</div>

</div>

<!-- RIGHT SIDE -->
<div class="col-md-5 mx-auto">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>Add Question</h4>

</div>
<div class="card-body" style="max-height:900px; overflow-y:auto;">

<form action="save_question.php" method="POST" id="addQuestionForm">




<div class="mb-3">
<label>Question Type</label>
<select name="question_type" class="form-select">
    <option>MCQ</option>
</select>
</div>

<div class="row">

<div class="col-md-6">
<label>Subject</label>
<input type="text" name="subject" class="form-control" required>
</div>

<div class="col-md-6">
<label>Category</label>
<input type="text" name="category" class="form-control" required>
</div>

</div>

<br>

<label>Difficulty</label>

<select name="difficulty" class="form-select">
    <option>Easy</option>
    <option>Medium</option>
    <option>Hard</option>
</select>

<br>

<label>Question</label>

<textarea name="question" class="form-control" rows="4" required></textarea>

<br>

<label>Option A</label>
<input type="text" name="a" class="form-control" required>

<br>

<label>Option B</label>
<input type="text" name="b" class="form-control" required>

<br>

<label>Option C</label>
<input type="text" name="c" class="form-control" required>

<br>

<label>Option D</label>
<input type="text" name="d" class="form-control" required>

<br>

<label>Correct Answer</label><br>

<input type="radio" name="answer" value="A" required> A
<input type="radio" name="answer" value="B"> B
<input type="radio" name="answer" value="C"> C
<input type="radio" name="answer" value="D"> D

<br><br>

<div class="form-check">
    <input class="form-check-input" type="checkbox" name="review">
    <label class="form-check-label">
        Mark for Review
    </label>
</div>

<br>

<button type="submit" class="btn btn-success w-100">
    Save Question
</button>

</form>

</div>
</div>

</div>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>