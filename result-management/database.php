<?php
/**
 * ==========================================
 * Student Result Management & Reports
 * Database Connection & Helper Functions
 * ==========================================
 */

$host = "localhost";
$username = "root";
$password = "";
$dbname = "examshield_lps";

try {
    // Connect to MySQL server first without selecting DB to ensure DB exists
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbname`");

    // Auto-initialize tables if results table does not exist
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'results'")->rowCount();
    if ($tableCheck === 0) {
        $sqlFile = __DIR__ . '/database.sql';
        if (file_exists($sqlFile)) {
            $sqlContent = file_get_contents($sqlFile);
            $pdo->exec($sqlContent);
        }
    }

} catch (PDOException $e) {
    die("<div style='padding: 20px; font-family: sans-serif; background: #fee2e2; color: #991b1b; border: 1px solid #f87171; border-radius: 8px; margin: 20px;'>
        <h3><i class='fas fa-exclamation-triangle'></i> Database Connection Error</h3>
        <p>" . htmlspecialchars($e->getMessage()) . "</p>
        <small>Please verify that your MySQL service is running in XAMPP and configuration credentials are correct.</small>
    </div>");
}

/**
 * Execute a query with parameters and return PDOStatement
 */
function dbQuery($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

/**
 * Fetch all records
 */
function dbFetchAll($sql, $params = []) {
    return dbQuery($sql, $params)->fetchAll();
}

/**
 * Fetch single record
 */
function dbFetchOne($sql, $params = []) {
    return dbQuery($sql, $params)->fetch();
}

/**
 * Helper to calculate percentage
 */
function calculatePercentage($marks, $total_marks) {
    if ($total_marks <= 0) return 0;
    return round(($marks / $total_marks) * 100, 2);
}

/**
 * Helper to calculate pass/fail status
 */
function calculateStatus($percentage) {
    return $percentage >= 40 ? 'Pass' : 'Fail';
}
?>
