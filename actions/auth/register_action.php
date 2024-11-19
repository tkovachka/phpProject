<?php
include '../../database/db_connection.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    if(strlen($username) < 4 || strlen($password) < 8){
        die("Username less than 6 characters or password less than 8 characters !");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role);");
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":password", $hashedPassword);
    $stmt->bindValue(":role", $role);

    $stmt->execute();

    echo "Your registration was successful. <a href='../../pages/auth/login.php'>Login here</a>";

    $db->close();
}

?>
