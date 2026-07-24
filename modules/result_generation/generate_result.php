<?php

$pageTitle = "Generate Result";

require_once("../../includes/header.php");
require_once("../../config/database.php");

$percentage = "";
$status = "";
$grade = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentName = trim($_POST['student_name']);
    $rollNo = trim($_POST['roll_no']);
    $department = trim($_POST['department']);
    $examName = trim($_POST['exam_name']);

    $obtainedMarks = (int)$_POST['obtained_marks'];
    $totalMarks = (int)$_POST['total_marks'];

    if ($totalMarks > 0) {

        $percentage = round(($obtainedMarks / $totalMarks) * 100, 2);

        if ($percentage >= 90) {
            $grade = "A+";
        } elseif ($percentage >= 80) {
            $grade = "A";
        } elseif ($percentage >= 70) {
            $grade = "B+";
        } elseif ($percentage >= 60) {
            $grade = "B";
        } elseif ($percentage >= 50) {
            $grade = "C";
        } elseif ($percentage >= 40) {
            $grade = "D";
        } else {
            $grade = "F";
        }

        $status = ($percentage >= 40) ? "PASS" : "FAIL";
    }

}

?>

<div class="container-fluid mt-4">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h3>
                <i class="fas fa-graduation-cap"></i>
                Generate Student Result
            </h3>

        </div>

        <div class="card-body">

            <form method="POST">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Student Name</label>

                        <input type="text"
                               name="student_name"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Roll Number</label>

                        <input type="text"
                               name="roll_no"
                               class="form-control"
                               required>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Department</label>

                        <select name="department"
                                class="form-select"
                                required>

                            <option value="">Select Department</option>
                            <option>Computer</option>
                            <option>IT</option>
                            <option>AIML</option>
                            <option>ENTC</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Exam Name</label>

                        <input type="text"
                               name="exam_name"
                               class="form-control"
                               required>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Obtained Marks</label>

                        <input type="number"
                               name="obtained_marks"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Total Marks</label>

                        <input type="number"
                               name="total_marks"
                               class="form-control"
                               required>

                    </div>

                </div>

                <button type="submit"
                        class="btn btn-success">

                    <i class="fas fa-calculator"></i>

                    Generate Result

                </button>

            </form>

            <?php if($_SERVER["REQUEST_METHOD"]=="POST"){ ?>

            <hr>

            <h4 class="mb-3">

                Result Summary

            </h4>

            <table class="table table-bordered">

                <tr>
                    <th>Student Name</th>
                    <td><?php echo htmlspecialchars($studentName); ?></td>
                </tr>

                <tr>
                    <th>Roll Number</th>
                    <td><?php echo htmlspecialchars($rollNo); ?></td>
                </tr>

                <tr>
                    <th>Department</th>
                    <td><?php echo htmlspecialchars($department); ?></td>
                </tr>

                <tr>
                    <th>Exam</th>
                    <td><?php echo htmlspecialchars($examName); ?></td>
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
                    <th>Grade</th>
                    <td>
                        <span class="badge bg-info">
                            <?php echo $grade; ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>

                        <?php if($status=="PASS"){ ?>

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

            <div class="mt-3">

                <a href="marksheet.php"
                   class="btn btn-primary">

                    View Marksheet

                </a>

                <a href="export_pdf.php"
                   class="btn btn-danger">

                    Export PDF

                </a>

            </div>

            <?php } ?>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>