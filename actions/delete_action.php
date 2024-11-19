<?php
include "../database/db_connection.php";
include "../jwt_helper.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    if (isset($_SESSION['token'])) {
        $decodedToken = decodeJWT($_SESSION['token']);
        if ($decodedToken && $decodedToken->role === 'Admin') {
            $id = intval($_POST["id"]);

            $db = connectDatabase();
            $stmt = $db->prepare("DELETE FROM books WHERE id = :id");
            $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
            if ($stmt->execute()) {
                $db->close();
                header("Location: ../index.php");
            } else {
                echo "Error deleting book";
            }
        } else {
            header("Location: ../index.php");
        }
    } else {
        header('Location: ../pages/auth/login.php');
    }
}
?>
