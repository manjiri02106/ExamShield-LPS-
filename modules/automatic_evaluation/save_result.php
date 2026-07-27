<?php
/**
 * ==========================================
 * ExamShield LPS
 * Save Result
 * ==========================================
 */

require_once("../../config/config.php");
require_once("../../config/database.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_name = trim($_POST['student_name']);
    $department   = trim($_POST['department']);
    $exam_name    = trim($_POST['exam_name']);
    $marks        = (int)$_POST['marks'];
    $total_marks  = (int)$_POST['total_marks'];

    // Calculate Percentage
    $percentage = 0;

    if ($total_marks > 0) {
        $percentage = round(($marks / $total_marks) * 100, 2);
    }

    // Result Status
    if ($percentage >= 40) {
        $status = "Pass";
    } else {
        $status = "Fail";
    }

    // Check Database Connection
    if (isset($conn)) {

        $sql = "INSERT INTO results
                (student_name, department, exam_name, marks, total_marks, percentage, status)
                VALUES
                ('$student_name',
                 '$department',
                 '$exam_name',
                 '$marks',
                 '$total_marks',
                 '$percentage',
                 '$status')";

        if(mysqli_query($conn,$sql)){
            $message = "<div class='alert alert-success'>
                            Result Saved Successfully.
                        </div>";
        }else{
            $message = "<div class='alert alert-danger'>
                            ".mysqli_error($conn)."
                        </div>";
        }

    } else {

        $message = "<div class='alert alert-danger'>
                        Database Connection Failed.
                    </div>";
    }

}

$pageTitle = "Save Result";

require_once("../../includes/header.php");

?>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3>Save Student Result</h3>

        </div>

        <div class="card-body">

            <?php echo $message; ?>

            <form method="POST">

                <div class="mb-3">
                    <label>Student Name</label>
                    <input type="text"
                           name="student_name"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Department</label>
                    <input type="text"
                           name="department"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Exam Name</label>
                    <input type="text"
                           name="exam_name"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Obtained Marks</label>
                    <input type="number"
                           name="marks"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Total Marks</label>
                    <input type="number"
                           name="total_marks"
                           class="form-control"
                           required>
                </div>

                <button type="submit"
                        class="btn btn-success">

                    Save Result

                </button>

            </form>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>