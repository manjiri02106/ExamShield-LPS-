<?php

$pageTitle = "Automatic Evaluation";

require_once("../../config/config.php");
require_once("../../includes/header.php");

$obtainedMarks = "";
$totalMarks = "";
$percentage = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentName = trim($_POST['student_name']);
    $department = trim($_POST['department']);
    $examName = trim($_POST['exam_name']);

    $obtainedMarks = (int)$_POST['obtained_marks'];
    $totalMarks = (int)$_POST['total_marks'];

    if ($totalMarks > 0) {

        $percentage = round(($obtainedMarks / $totalMarks) * 100, 2);

        if ($percentage >= 40) {
            $status = "PASS";
            $badge = "success";
        } else {
            $status = "FAIL";
            $badge = "danger";
        }

    }

}

?>

<div class="container-fluid mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3>
                <i class="fas fa-check-circle"></i>
                Automatic Evaluation
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

                </div>

                <div class="mb-3">

                    <label>Exam Name</label>

                    <input type="text"
                           name="exam_name"
                           class="form-control"
                           required>

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

                    Evaluate Result

                </button>

            </form>

            <?php if($_SERVER["REQUEST_METHOD"]=="POST"){ ?>

            <hr>

            <h4 class="mb-3">

                Evaluation Result

            </h4>

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
                    <th>Status</th>
                    <td>

                        <span class="badge bg-<?php echo $badge; ?>">

                            <?php echo $status; ?>

                        </span>

                    </td>

                </tr>

            </table>

            <?php } ?>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>