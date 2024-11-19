<?php
session_start();

include '../../database/db_connection.php';
include '../../jwt_helper.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $db = connectDatabase();

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(":username", $username);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if($user && password_verify($password, $user["password"])){
        $token = createJWT($user["id"], $username, $user["role"]);

        session_regenerate_id(true);
        $_SESSION['token'] = $token;

        header("Location: ../../index.php");

    } else {
        echo "Username or password is incorrect. Please <a href='../../pages/auth/login.php'>try again</a>.";
    }

}


?>