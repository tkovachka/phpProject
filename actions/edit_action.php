<?php
include '../database/db_connection.php';
include '../jwt_helper.php';

session_start();

if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: ../pages/auth/login.php');
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])){
    $id = intval($_POST["id"]);
    $title = $_POST["title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $year = intval($_POST["year"]);
    $isbn = $_POST["isbn"];

    $db = connectDatabase();
    $stmt = $db->prepare("UPDATE books SET title = :title, author = :author, genre=:genre, year = :year, isbn=:isbn WHERE id = :id");
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":author", $author);
    $stmt->bindValue(":genre", $genre);
    $stmt->bindValue(":year", $year);
    $stmt->bindValue(":isbn", $isbn);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    $db->close();
    header("Location: ../index.php");
}

?>
