<?php
session_start();
require "../database/db.php";
require "../jwt_helper.php";

if(!isset($_SESSION['token']) || !decodeJWT($_SESSION["token"])){
    header('Location: ../pages/auth/login.php');
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);

    $db = connectDB();

    $query = $db->prepare("SELECT * FROM movies WHERE id = :id");
    $query->bindValue(":id", $id, SQLITE3_INTEGER);
    $result = $query->execute();
    $movie = $result->fetchArray(SQLITE3_ASSOC);
    if (htmlspecialchars($movie['rating']) >= 8.0) {
        echo "Movie review deletion not allowed, rating is higher than 8";
        exit;
    }
    if (htmlspecialchars($movie['username']) != decodeJWT($_SESSION['token'])->username) {
        echo "Movie review deletion not allowed, you are not the author of this review";
        exit;
    }

    $stmt = $db->prepare("DELETE FROM movies WHERE id = :id");
    $stmt->bindValue(":id", $id);
    if($stmt->execute()){
        echo "Movie review deleted successfully";
        header("Location: ../index.php");
    } else {
        echo "Movie review delete failed";
    }
}

?>
