<?php
session_start();
require 'jwt_helper.php';

if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])){
    header ("Location: /pages/auth/login.php");
} else {
    $username = $_SESSION['token']->username;
}
?>

<form method="post" action="../handlers/create_handler.php">
    <div>
        <label for="title">Title</label>
        <input id="title" name="title" required type="text">
    </div>
    <div>
        <label for="content">Content</label>
        <input id="content" name="content" required type="text">
    </div>
    <div>
        <label for="date">Date</label>
        <input id="date" name="date_created" required type="date">
    </div>
    <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?? "" ?>">
    <button type="submit">Create note</button>
</form>
