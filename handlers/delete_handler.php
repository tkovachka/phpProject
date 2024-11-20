<?php
session_start();
require '../db_connection.php';
require '../jwt_helper.php';

if (!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header("Location: /pages/auth/login.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);

    $db = connect_database();

    $stmt = $db->prepare("DELETE FROM notes WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error deleting note from db: " . $db->lastErrorMsg();
    }
}

?>
