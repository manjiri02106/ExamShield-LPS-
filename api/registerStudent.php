<?php

require_once "../config/database.php";

header("Content-Type: application/json");

try {

    $name = "Taha Yusuf Attarwala";
    $email = "student" . time() . "@gmail.com";
    $password = password_hash("123456", PASSWORD_DEFAULT);
    $branch = "AIML";
    $semester = 1;

    $sql = "INSERT INTO students(name, email, password, branch, semester)
            VALUES(?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $name,
        $email,
        $password,
        $branch,
        $semester
    ]);

    echo json_encode([
        "status" => true,
        "message" => "Student Registered Successfully"
    ]);

} catch(PDOException $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);

}

?>