<?php
/**
 * ==========================================
 * ExamShield LPS - Results Modules Database Bridge
 * Uses centralized config when available, falls back to direct connection.
 * ==========================================
 */

$host = "localhost";
$username = "root";
$password = "";
$dbname = "examshield_lps";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("Database Connection Error: " . htmlspecialchars($e->getMessage()));
}

function dbQuery($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function dbFetchAll($sql, $params = []) {
    return dbQuery($sql, $params)->fetchAll();
}

function dbFetchOne($sql, $params = []) {
    return dbQuery($sql, $params)->fetch();
}

function calculatePercentage($marks, $total_marks) {
    if ($total_marks <= 0) return 0.00;
    return round(($marks / $total_marks) * 100, 2);
}

function calculateStatus($percentage) {
    return $percentage >= 40 ? 'Pass' : 'Fail';
}
?>
