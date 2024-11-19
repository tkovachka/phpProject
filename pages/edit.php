<?php
include '../database/db_connection.php';
include '../jwt_helper.php';

session_start();

if (!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: auth/login.php');
}

if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])){
    $id = intval($_GET["id"]);
    $db = connectDatabase();
    $stmt = $db->prepare("SELECT * FROM books WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $book = $result->fetchArray(SQLITE3_ASSOC);

    $db->close();
}
?>

<?php if($book): ?>
<form method="post" action="../actions/edit_action.php">
    <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($book['title']) ?>" required><br>
    <label for="author">Author</label>
    <input type="text" name="author" id="author" value="<?= htmlspecialchars($book['author']) ?>" required><br>
    <label for="genre">Genre</label>
    <select name="genre" id="genre" required>
        <option <?= htmlspecialchars($book['genre']) === "Romance" ? 'selected=true' : '' ?> value="Romance">Romance</option>
        <option <?= htmlspecialchars($book['genre']) === "Thriller" ? 'selected=true' : '' ?> value="Thriller">Thriller</option>
        <option <?= htmlspecialchars($book['genre']) === "Mystery" ? 'selected=true' : '' ?> value="Mystery">Mystery</option>
        <option <?= htmlspecialchars($book['genre']) === "Fantasy" ? 'selected=true' : '' ?> value="Fantasy">Fantasy</option>
    </select><br>
    <label for="year">Year</label>
    <input type="number" name="year" id="year" value="<?= htmlspecialchars($book['year']) ?>" required><br>
    <label for="isbn">ISBN</label>
    <input type="text" name="isbn" id="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" required><br>
    <button type="submit">Save</button>
</form>
<?php endif?>