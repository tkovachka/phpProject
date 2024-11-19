<?php
session_start();
require '../../database/db.php';
require '../../jwt_helper.php';

if (isset($_SESSION['token']) && decodeJwt($_SESSION['token'])) {
    header("Location: ../../index.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($username < 6 || $password < 8){
        echo "Invalid username(min 6 chars) or password(min 8 chars)";
        exit;
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $db=connectDB();
    $stmt=$db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashedPassword);
    try {
        $stmt->execute();
        echo "User saved successfully! <a href='../../pages/auth/login.php'>Log in here</a>";
    } catch (Exception $e) {
        if($e->getCode() == 23000) {
            echo "Username already taken!";
        } else {
            echo "Error saving user: ".$e->getMessage();
        }
    }
    $db->close();
}
?>
