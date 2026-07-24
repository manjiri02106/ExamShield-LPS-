<?php
/**
 * ==========================================
 * ExamShield LPS
 * Footer
 * ==========================================
 */
?>

        </div>
        <!-- End Main Content -->

    </div>
    <!-- End Wrapper -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Global JavaScript -->
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

    <!-- Dashboard Charts -->
    <script src="<?php echo BASE_URL; ?>assets/js/charts.js"></script>

    <!-- Attendance Module -->
    <script src="<?php echo BASE_URL; ?>assets/js/attendance.js"></script>

    <!-- Automatic Evaluation -->
    <script src="<?php echo BASE_URL; ?>assets/js/evaluation.js"></script>

    <!-- Custom Page Scripts -->
    <?php
    if (isset($pageScript)) {
        echo '<script src="' . BASE_URL . 'assets/js/' . $pageScript . '"></script>';
    }
    ?>

    <!-- Footer -->
    <footer class="text-center mt-5 py-3 bg-light border-top">
        <p class="mb-0">
            &copy; <?php echo date("Y"); ?>
            <strong>ExamShield LPS</strong> |
            Version <?php echo APP_VERSION; ?>
        </p>
    </footer>

</body>
</html>