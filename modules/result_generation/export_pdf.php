<?php

$pageTitle = "Export PDF";

require_once("../../includes/header.php");
require_once("../../config/database.php");

?>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-danger text-white">

            <h3>
                <i class="fas fa-file-pdf"></i>
                Export Result PDF
            </h3>

        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label>Student Roll Number</label>

                    <input type="text"
                           name="roll_no"
                           class="form-control"
                           placeholder="Enter Roll Number"
                           required>

                </div>

                <button type="submit"
                        class="btn btn-danger">

                    <i class="fas fa-file-pdf"></i>

                    Generate PDF

                </button>

            </form>

            <?php

            if($_SERVER["REQUEST_METHOD"]=="POST"){

                $roll = htmlspecialchars($_POST['roll_no']);

                echo "<hr>";

                echo "<div class='alert alert-success'>";

                echo "<h4>PDF Generated Successfully</h4>";

                echo "<p><strong>Roll Number :</strong> $roll</p>";

                echo "<p>This is a demo page. PDF generation will be connected later using a PHP PDF library such as FPDF or TCPDF.</p>";

                echo "</div>";

            }

            ?>

        </div>

    </div>

</div>

<?php

require_once("../../includes/footer.php");

?>