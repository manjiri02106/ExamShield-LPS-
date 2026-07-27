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
    <title>Edit Question</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Edit Question</h3>

</div>

<div class="card-body">

<form action="update_question.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<label>Subject</label>
<input type="text"
class="form-control"
name="subject"
value="<?php echo $row['subject']; ?>">

<br>

<label>Category</label>
<input type="text"
class="form-control"
name="category"
value="<?php echo $row['category']; ?>">

<br>

<label>Difficulty</label>

<select
name="difficulty"
class="form-select">

<option <?php if($row['difficulty']=="Easy") echo "selected"; ?>>Easy</option>

<option <?php if($row['difficulty']=="Medium") echo "selected"; ?>>Medium</option>

<option <?php if($row['difficulty']=="Hard") echo "selected"; ?>>Hard</option>

</select>

<br>

<label>Question</label>

<textarea
class="form-control"
name="question"
rows="4"><?php echo $row['question']; ?></textarea>

<br>

<label>Option A</label>
<input
class="form-control"
type="text"
name="a"
value="<?php echo $row['option_a']; ?>">

<br>

<label>Option B</label>
<input
class="form-control"
type="text"
name="b"
value="<?php echo $row['option_b']; ?>">

<br>

<label>Option C</label>
<input
class="form-control"
type="text"
name="c"
value="<?php echo $row['option_c']; ?>">

<br>

<label>Option D</label>
<input
class="form-control"
type="text"
name="d"
value="<?php echo $row['option_d']; ?>">

<br>

<label>Correct Answer</label>

<select
class="form-select"
name="answer">

<option value="A" <?php if($row['correct_answer']=="A") echo "selected"; ?>>A</option>

<option value="B" <?php if($row['correct_answer']=="B") echo "selected"; ?>>B</option>

<option value="C" <?php if($row['correct_answer']=="C") echo "selected"; ?>>C</option>

<option value="D" <?php if($row['correct_answer']=="D") echo "selected"; ?>>D</option>

</select>

<br>

<button class="btn btn-success">

Update Question

</button>

<a href="index.php" class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</body>

</html>