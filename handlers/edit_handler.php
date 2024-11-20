<?php
session_start();
require '../jwt_helper.php';
require '../db_connection.php';

if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])){
    header ("Location: /pages/auth/login.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    $title = $_POST["title"];
    $content = $_POST["content"];
    $username = $_POST["username"];
    $date_created = $_POST["date_created"];

    $db = connect_database();

    $stmt = $db->prepare("UPDATE notes SET username=:username, title=:title, content=:content, date_created=:date_created WHERE id=:id");

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':date_created', $date_created);
    $stmt->bindValue(':id', $id);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error updating note in db: " . $db->lastErrorMsg();
    }
}

?>
