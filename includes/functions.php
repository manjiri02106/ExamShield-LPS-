<?php
/**
 * ==========================================
 * ExamShield LPS
 * Common Functions
 * ==========================================
 */

/**
 * Sanitize Input
 */
function cleanInput($data)
{
    global $conn;

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    if (isset($conn)) {
        $data = mysqli_real_escape_string($conn, $data);
    }

    return $data;
}

/**
 * Redirect Function
 */
function redirect($url)
{
    header("Location: " . $url);
    exit();
}

/**
 * Display Success Message
 */
function successMessage($message)
{
    return '<div class="alert alert-success">' . $message . '</div>';
}

/**
 * Display Error Message
 */
function errorMessage($message)
{
    return '<div class="alert alert-danger">' . $message . '</div>';
}

/**
 * Count Records
 */
function countRecords($table)
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    return 0;
}

/**
 * Get Current Date
 */
function currentDate()
{
    return date("Y-m-d");
}

/**
 * Get Current Date Time
 */
function currentDateTime()
{
    return date("Y-m-d H:i:s");
}

/**
 * Calculate Percentage
 */
function calculatePercentage($obtained, $total)
{
    if ($total == 0) {
        return 0;
    }

    return round(($obtained / $total) * 100, 2);
}

/**
 * Calculate Grade
 */
function calculateGrade($percentage)
{
    if ($percentage >= 90) {
        return "A+";
    } elseif ($percentage >= 80) {
        return "A";
    } elseif ($percentage >= 70) {
        return "B";
    } elseif ($percentage >= 60) {
        return "C";
    } elseif ($percentage >= 40) {
        return "D";
    } else {
        return "F";
    }
}

/**
 * Result Status
 */
function resultStatus($percentage)
{
    return ($percentage >= 40) ? "Pass" : "Fail";
}

/**
 * Attendance Percentage
 */
function attendancePercentage($present, $total)
{
    if ($total == 0) {
        return 0;
    }

    return round(($present / $total) * 100, 2);
}

/**
 * Format Date
 */
function formatDate($date)
{
    return date("d-m-Y", strtotime($date));
}

/**
 * Generate Random Exam Code
 */
function generateExamCode()
{
    return "EXAM-" . rand(1000, 9999);
}

/**
 * Generate Random Result Code
 */
function generateResultCode()
{
    return "RES-" . rand(10000, 99999);
}
?>