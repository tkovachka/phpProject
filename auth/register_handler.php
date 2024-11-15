<?php
session_start();
require '../db.php';

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    try {
        $stmt->execute([':username' => $username, ':password' => $hashedPassword]);
        echo "Registration successful, <a href='login_form.php'>Log in here</a>";
    } catch (PDOException $e) {
        if($e->getCode() == 23000) {
            echo "Username already taken";
        } else {
            die("Error: ".$e->getMessage());
        }
    }
}
