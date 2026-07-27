<?php
session_start();

include("../config/database.php");

// CSV Download Headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=questions_export.csv');

// Create output stream
$output = fopen('php://output', 'w');

// CSV Header
fputcsv($output, array(
    'Question',
    'Option A',
    'Option B',
    'Option C',
    'Option D',
    'Answer'
));

// Fetch all questions
$sql = "SELECT * FROM questions ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Write rows
while ($row = mysqli_fetch_assoc($result)) {

    fputcsv($output, array(
        $row['question'],
        $row['option_a'],
        $row['option_b'],
        $row['option_c'],
        $row['option_d'],
        $row['correct_answer']
    ));

}

fclose($output);
exit();
?>