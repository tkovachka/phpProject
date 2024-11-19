<?php
include '../jwt_helper.php';

session_start();

if (!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: auth/login.php');
}
?>
<form method="post" action="../actions/create_action.php">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" required><br>
    <label for="author">Author</label>
    <input type="text" name="author" id="author" required><br>
    <label for="genre">Genre</label>
    <select name="genre" id="genre" required>
        <option value="Romance">Romance</option>
        <option value="Thriller">Thriller</option>
        <option value="Mystery">Mystery</option>
        <option value="Fantasy">Fantasy</option>
    </select><br>
    <label for="year">Year</label>
    <input type="number" name="year" id="year" required><br>
    <label for="isbn">ISBN</label>
    <input type="text" name="isbn" id="isbn" required><br>
    <button type="submit">Add book</button>
</form>
