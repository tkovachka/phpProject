<?php
session_start();
require '../database/db.php';
require '../jwt_helper.php';

if (isset($_SESSION['token']) && decodeJwt($_SESSION['token'])) {
    $user = decodeJwt($_SESSION['token'])->username;
} else {
    header("Location: auth/login.php");
}
?>

<form method="post" action="../handlers/add_handler.php">
    <div>
        <label for="title">Title</label>
        <input id="title" name="title" type="text" required>
    </div>
    <div>
        <label for="director">Director</label>
        <input id="director" name="director" type="text" required>
    </div>
    <div>
        <label for="genre">Genre</label>
        <select id="genre" name="genre" required>
            <option value="Action">Action</option>
            <option value="Drama">Drama</option>
            <option value="Sci-Fi">Sci-Fi</option>
            <option value="Comedy">Comedy</option>
            <option value="Rom-com">Rom-com</option>
            <option value="Horror">Horror</option>
            <option value="Mystery">Mystery</option>
            <option value="Adventure">Adventure</option>
        </select>
    </div>
    <div>
        <label for="rating">Rating</label>
        <input id="rating" name="rating" type="number" step="0.1" required>
    </div>
    <div>
        <label for="date">Date</label>
        <input id="date" name="date" type="date" required>
    </div>
    <div>
        <label for="description">Description</label>
        <input id="description" name="description" type="text" required>
    </div>
    <input type="hidden" name="username" value="<?= htmlspecialchars($user)?>">
    <button type="submit">Add new review</button>
</form>