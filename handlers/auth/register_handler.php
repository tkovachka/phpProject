<?php
session_start();
require '../../jwt_helper.php';
require '../../db_connection.php';

if (isset($_SESSION['token']) && decodeJWT($_SESSION['token'])) {
    header("Location: ../../index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $db = connect_database();

    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashedPassword);
    if ($stmt->execute()) {
        header("Location:../../pages/auth/login.php");
    } else {
        echo "Error registering new user: " . $db->lastErrorMsg();
    }
}


?>
