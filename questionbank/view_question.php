<?php
session_start();


include("../config/database.php");

$id = $_GET['id'];

$sql = "SELECT * FROM questions WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Question</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-info text-white">
<h3>View Question</h3>
</div>

<div class="card-body">

<p><strong>Subject:</strong> <?php echo $row['subject']; ?></p>

<p><strong>Category:</strong> <?php echo $row['category']; ?></p>

<p><strong>Difficulty:</strong> <?php echo $row['difficulty']; ?></p>

<p><strong>Question:</strong><br>
<?php echo $row['question']; ?></p>

<hr>

<p><strong>Option A:</strong> <?php echo $row['option_a']; ?></p>

<p><strong>Option B:</strong> <?php echo $row['option_b']; ?></p>

<p><strong>Option C:</strong> <?php echo $row['option_c']; ?></p>

<p><strong>Option D:</strong> <?php echo $row['option_d']; ?></p>

<hr>

<p><strong>Correct Answer:</strong> <?php echo $row['correct_answer']; ?></p>

<a href="index.php" class="btn btn-secondary">
Back
</a>

</div>

</div>

</div>

</body>
</html>