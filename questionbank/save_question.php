<?php

session_start();


include("../config/database.php");

$subject = $_POST['subject'];
$category = $_POST['category'];
$difficulty = $_POST['difficulty'];
$question = $_POST['question'];

$a = $_POST['a'];
$b = $_POST['b'];
$c = $_POST['c'];
$d = $_POST['d'];

$answer = $_POST['answer'];

$question_type = $_POST['question_type'];
$review = isset($_POST['review']) ? 1 : 0;

$sql = "INSERT INTO questions
(question_type,
subject,
category,
difficulty,
question,
option_a,
option_b,
option_c,
option_d,
correct_answer,
mark_review)
VALUES
('$question_type',
'$subject',
'$category',
'$difficulty',
'$question',
'$a',
'$b',
'$c',
'$d',
'$answer',
'$review')";

if (mysqli_query($conn, $sql)) {
    echo "Question Added Successfully";
    echo "<br><br>";
   header("Location: index.php?msg=added#addQuestionForm");
exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

?>