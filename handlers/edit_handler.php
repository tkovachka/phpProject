<?php
session_start();
require "../database/db.php";
require "../jwt_helper.php";

if (!isset($_SESSION['token']) || !decodeJwt($_SESSION['token'])) {
    header("Location: ../pages/auth/login.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    $title = $_POST["title"];
    $director = $_POST["director"];
    $genre = $_POST["genre"];
    $rating = doubleval($_POST["rating"]);
    $date = $_POST["date"];
    $description = $_POST["description"];
    $username = $_POST["username"];

    if (htmlspecialchars($username) != decodeJWT($_SESSION['token'])->username) {
        echo "Movie review edit not allowed, you are not the author of this review";
        exit;
    }

    $db = connectDb();
    $stmt = $db->prepare('UPDATE movies SET title = :title, director = :director, genre = :genre, rating = :rating, date = :date, description = :description, username = :username WHERE id=:id');
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':director', $director);
    $stmt->bindValue(':genre', $genre);
    $stmt->bindValue(':rating', $rating, SQLITE3_FLOAT);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    if ($stmt->execute()) {
        echo "Movie updated successfully!";
        header("Location: ../index.php");
    } else {
        echo "Error updating movie.";
    }

    $db->close();
}

?>

