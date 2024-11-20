<?php
session_start();
require '../db_connection.php';
require '../jwt_helper.php';

if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])){
    header ("Location: /pages/auth/login.php");
} else {
    $username = $_SESSION['token']->username;
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $db = connect_database();

    $stmt = $db->prepare("SELECT * FROM notes WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $note = $result->fetchArray(SQLITE3_ASSOC);
}

?>

<form method="post" action="../handlers/edit_handler.php">
    <input type="hidden" name="id" value="<?= htmlspecialchars($note['id']) ?>">
    <div>
        <label for="title">Title</label>
        <input id="title" name="title" required type="text"
               value="<?= htmlspecialchars($note['title'])?>">
    </div>
    <div>
        <label for="content">Content</label>
        <input id="content" name="content" required type="text"
               value="<?= htmlspecialchars($note['content']) ?>">
    </div>
    <div>
        <label for="date">Date</label>
        <input id="date" name="date_created" required type="date"
               value="<?= htmlspecialchars($note['date_created']) ?>">
    </div>
    <input type="hidden" name="username" value="<?= $username ?? "usernameHere" ?>">
    <button type="submit">Update note</button>
</form>
