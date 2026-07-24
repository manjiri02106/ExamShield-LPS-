<?php
/**
 * ==========================================
 * ExamShield LPS
 * Calculate Marks
 * ==========================================
 */

require_once("../../config/config.php");

$totalMarks = 0;
$obtainedMarks = 0;
$percentage = 0;
$result = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentName = trim($_POST['student_name']);
    $department = trim($_POST['department']);
    $subject = trim($_POST['subject']);
    $obtainedMarks = (int)$_POST['obtained_marks'];
    $totalMarks = (int)$_POST['total_marks'];

    if ($totalMarks > 0) {

        $percentage = round(($obtainedMarks / $totalMarks) * 100, 2);

        if ($percentage >= 40) {
            $result = "Pass";
        } else {
            $result = "Fail";
        }

    }

}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Calculate Marks</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3>Calculate Student Marks</h3>

        </div>

        <div class="card-body">

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

                    <label>Subject</label>

                    <input type="text"
                           name="subject"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Obtained Marks</label>

                    <input type="number"
                           name="obtained_marks"
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

                <button type="submit" class="btn btn-success">

                    Calculate Result

                </button>

            </form>

            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>

                <hr>

                <h4>Result</h4>

                <table class="table table-bordered">

                    <tr>
                        <th>Student</th>
                        <td><?php echo htmlspecialchars($studentName); ?></td>
                    </tr>

                    <tr>
                        <th>Department</th>
                        <td><?php echo htmlspecialchars($department); ?></td>
                    </tr>

                    <tr>
                        <th>Subject</th>
                        <td><?php echo htmlspecialchars($subject); ?></td>
                    </tr>

                    <tr>
                        <th>Obtained Marks</th>
                        <td><?php echo $obtainedMarks; ?></td>
                    </tr>

                    <tr>
                        <th>Total Marks</th>
                        <td><?php echo $totalMarks; ?></td>
                    </tr>

                    <tr>
                        <th>Percentage</th>
                        <td><?php echo $percentage; ?>%</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>

                            <?php if ($result == "Pass") { ?>

                                <span class="badge bg-success">
                                    PASS
                                </span>

                            <?php } else { ?>

                                <span class="badge bg-danger">
                                    FAIL
                                </span>

                            <?php } ?>

                        </td>
                    </tr>

                </table>

            <?php } ?>

        </div>

    </div>

</div>

</body>

</html>