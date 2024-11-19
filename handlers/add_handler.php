<?php
session_start();
require '../jwt_helper.php';
require '../database/db.php';

if (!isset($_SESSION['token']) || !decodeJwt($_SESSION['token'])) {
    header("Location: ../pages/auth/login.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];
    $director = $_POST['director'];
    $genre = $_POST['genre'];
    $rating = doubleval(['rating']);
    $date = $_POST['date'];
    $description = $_POST['description'];
    $username = $_POST['username'];

    $db = connectDb();
    $stmt = $db->prepare("INSERT INTO movies (title, director, genre, rating, date, description, username) VALUES (:title, :director, :genre, :rating, :date, :description, :username)");
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':director', $director);
    $stmt->bindValue(':genre', $genre);
    $stmt->bindValue(':rating', $rating, SQLITE3_FLOAT);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':username', $username);
    if($stmt->execute()){
        echo "Movie added!";
        header("Location: ../index.php");
    } else {
        echo "Error adding movie to database!";
    }
    $db->close();
}
?>
