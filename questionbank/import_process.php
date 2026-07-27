<?php
session_start();



include("../config/database.php");

if (isset($_POST['submit']) && isset($_FILES['csv_file'])) {

    $file = fopen($_FILES['csv_file']['tmp_name'], "r");

    // Skip header
    fgetcsv($file);

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

        // Skip empty rows
        if (count($data) < 6) {
            continue;
        }

        $question_type = "MCQ";
        $subject = "General";
        $category = "Theory";
        $difficulty = "Easy";

        $question = mysqli_real_escape_string($conn, trim($data[0]));
        $option_a = mysqli_real_escape_string($conn, trim($data[1]));
        $option_b = mysqli_real_escape_string($conn, trim($data[2]));
        $option_c = mysqli_real_escape_string($conn, trim($data[3]));
        $option_d = mysqli_real_escape_string($conn, trim($data[4]));
        $answer   = mysqli_real_escape_string($conn, trim($data[5]));

        $sql = "INSERT INTO questions
        (subject, category, difficulty, question,
         option_a, option_b, option_c, option_d,
         correct_answer, question_type, mark_review)
        VALUES
        ('$subject', '$category', '$difficulty',
         '$question', '$option_a', '$option_b',
         '$option_c', '$option_d',
         '$answer', '$question_type', 0)";

        mysqli_query($conn, $sql);
    }

    fclose($file);

    header("Location: index.php?msg=imported");
    exit();
}

header("Location: import_questions.php");
exit();
?>