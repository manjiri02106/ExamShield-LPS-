<?php
session_start();


include("../config/database.php");

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    $sql = "DELETE FROM questions WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting question.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>