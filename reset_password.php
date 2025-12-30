<?php
session_start();
require 'includes/config.php';

if(isset($_POST['forgot'])){
    $email = trim($_POST['email']);
    $sql = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user){
        $_SESSION['reset_user'] = $user['id'];
        header("Location: change_password.php");
        exit;
    } else {
        $_SESSION['error'] = "Email tidak terdaftar!";
        header("Location: forgot_password.php");
        exit;
    }
}
?>
