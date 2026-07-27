<?php
session_start();



include("../config/database.php");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Import Questions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h4><i class="fa-solid fa-file-import"></i> Import Questions (CSV)</h4>

        </div>

        <div class="card-body">

            <form action="import_process.php" method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label>Select CSV File</label>

                    <input
                        type="file"
                        name="csv_file"
                        class="form-control"
                        accept=".csv"
                        required>

                </div>

                <button type="submit" name="submit" class="btn btn-success">

                    <i class="fa-solid fa-upload"></i>

                    Import

                </button>

                <a href="index.php" class="btn btn-secondary">

                    Back

                </a>

            </form>

        </div>

    </div>

</div>

</body>

</html>