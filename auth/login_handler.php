<?php
session_start();
require '../db.php';
require '../jwt_helper.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(["username" => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $token = createJWT($user['id'], $user['username']);

        session_regenerate_id(true);
        $_SESSION['token'] = $token;

        header('Location: /pages/index/index.php');
    } else {
        exit;
    }
}
