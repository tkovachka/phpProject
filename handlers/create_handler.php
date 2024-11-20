<?php
session_start();
require '../db_connection.php';
require '../jwt_helper.php';

if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])){
    header ("Location: /pages/auth/login.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $username = $_POST["username"];
    $date_created = $_POST["date_created"];

    $db = connect_database();

    $stmt = $db->prepare("INSERT INTO notes(username, title, content, date_created) VALUES (:username, :title, :content, :date_created)");

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':date_created', $date_created);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error adding note to db: " . $db->lastErrorMsg();
    }
}

?>
