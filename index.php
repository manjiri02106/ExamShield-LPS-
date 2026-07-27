<?php

session_start();

include("config/database.php");

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE email='$email'
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit();

    } else {

        echo "Invalid Login";

    }

}

?>