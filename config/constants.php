<?php
/**
 * ==========================================
 * ExamShield LPS
 * Constants File
 * ==========================================
 */

// ==============================
// Project Details
// ==============================

define('PROJECT_NAME', 'ExamShield LPS');
define('PROJECT_VERSION', '1.0');
define('APP_NAME', PROJECT_NAME); // Backwards compatibility for old files
define('APP_VERSION', PROJECT_VERSION); // Backwards compatibility for old files
define('BASE_URL', 'http://localhost/ExamShield-LPS-/');

// ==============================
// Database Credentials
// ==============================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'examshield_lps');

// ==============================
// User Roles
// ==============================

define('ROLE_ADMIN', 'Admin');
define('ROLE_FACULTY', 'Faculty');
define('ROLE_STUDENT', 'Student');

// ==============================
// Exam Status
// ==============================

define('EXAM_SCHEDULED', 'Scheduled');
define('EXAM_ONGOING', 'Ongoing');
define('EXAM_COMPLETED', 'Completed');

// ==============================
// Result Status
// ==============================

define('RESULT_PASS', 'Pass');
define('RESULT_FAIL', 'Fail');

// ==============================
// Attendance Status
// ==============================

define('ATTENDANCE_PRESENT', 'Present');
define('ATTENDANCE_ABSENT', 'Absent');

// ==============================
// Default Settings
// ==============================

define('DEFAULT_TIMEZONE', 'Asia/Kolkata');
define('DEFAULT_LANGUAGE', 'en');

// ==============================
// Upload Settings
// ==============================

define('UPLOAD_PATH', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5 MB

// ==============================
// Date & Time Formats
// ==============================

define('DATE_FORMAT', 'd-m-Y');
define('TIME_FORMAT', 'H:i:s');
define('DATETIME_FORMAT', 'd-m-Y H:i:s');

// ==============================
// Pagination
// ==============================

define('RECORDS_PER_PAGE', 10);

// ==============================
// Messages
// ==============================

define('MSG_SAVE_SUCCESS', 'Record saved successfully.');
define('MSG_UPDATE_SUCCESS', 'Record updated successfully.');
define('MSG_DELETE_SUCCESS', 'Record deleted successfully.');
define('MSG_ERROR', 'Something went wrong. Please try again.');

?>