<?php
include '../database/db_connection.php';
include '../jwt_helper.php';

session_start();

if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: ../pages/auth/login.php');
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $title = $_POST["title"] ?? "";
    $author = $_POST["author"] ?? "";
    $genre = $_POST["genre"] ?? "";
    $year = intval($_POST["year"] ?? 0);
    $isbn = $_POST["isbn"] ?? 0;

    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO books (title,author,genre,year,isbn) VALUES (:title,:author,:genre,:year,:isbn)");
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":author", $author);
    $stmt->bindValue(":genre", $genre);
    $stmt->bindValue(":year", $year, SQLITE3_INTEGER);
    $stmt->bindValue(":isbn", $isbn);

    if($stmt->execute()){
        header("Location: ../index.php");
    } else {
        echo "Error saving book";
    }
    $db->close();
}
?>