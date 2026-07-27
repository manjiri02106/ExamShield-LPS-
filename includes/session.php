<?php
/**
 * ==========================================
 * ExamShield LPS
 * Session Management
 * ==========================================
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check Login
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Redirect if not logged in
 */
function checkLogin()
{
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
}

/**
 * Get Logged In User
 */
function getUserName()
{
    return $_SESSION['username'] ?? 'Guest';
}

/**
 * Get User Role
 */
function getUserRole()
{
    return $_SESSION['role'] ?? 'Guest';
}

/**
 * Check Admin
 */
function isAdmin()
{
    return (getUserRole() === 'Admin');
}

/**
 * Check Faculty
 */
function isFaculty()
{
    return (getUserRole() === 'Faculty');
}

/**
 * Check Student
 */
function isStudent()
{
    return (getUserRole() === 'Student');
}

/**
 * Logout
 */
function logout()
{
    session_unset();
    session_destroy();

    header("Location: ../login.php");
    exit();
}
?>