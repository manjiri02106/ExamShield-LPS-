<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<h2>Add New Question</h2>

<form action="save_question.php" method="POST">

    Subject:<br>
    <input type="text" name="subject" required><br><br>

    Category:<br>
    <input type="text" name="category" required><br><br>

    Difficulty:<br>
    <select name="difficulty" required>
        <option value="Easy">Easy</option>
        <option value="Medium">Medium</option>
        <option value="Hard">Hard</option>
    </select>

    <br><br>

    Question:<br>
    <textarea name="question" rows="4" cols="60" required></textarea>

    <br><br>

    Option A<br>
    <input type="text" name="a" required>

    <br><br>

    Option B<br>
    <input type="text" name="b" required>

    <br><br>

    Option C<br>
    <input type="text" name="c" required>

    <br><br>

    Option D<br>
    <input type="text" name="d" required>

    <br><br>

    Correct Answer<br>

    <select name="answer" required>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>

    <br><br>

    <input type="submit" value="Save Question">

</form>

</body>
</html>