<?php
session_start();
require '../database/db.php';
require '../jwt_helper.php';

if (isset($_SESSION['token']) && decodeJwt($_SESSION['token'])) {
    $user = decodeJwt($_SESSION['token'])->username;
} else {
    header("Location: auth/login.php");
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $db = connectDb();
    $stmt = $db->prepare("SELECT * FROM movies WHERE id = :id");
    $stmt->bindValue(":id", $id);
    $result = $stmt->execute();
    $movie = $result->fetchArray(SQLITE3_ASSOC);

    if($user != htmlspecialchars($movie['username'])){
        echo "Movie review edit not allowed, you are not the author of the review";
        exit;
    }
}

?>
<?php if ($movie): ?>
    <form method="post" action="../handlers/edit_handler.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($movie['id'])?>">
        <div>
            <label for="title">Title</label>
            <input id="title" name="title" type="text" required value="<?php echo htmlspecialchars($movie['title'])?>">
        </div>
        <div>
            <label for="director">Director</label>
            <input id="director" name="director" type="text" required value="<?php echo htmlspecialchars($movie['director'])?>">
        </div>
        <div>
            <label for="genre">Genre</label>
            <select id="genre" name="genre" required>
                <option value="Action" <?php if(htmlspecialchars($movie['genre']) === 'Action'): ?> selected <?php endif ?> >Action</option>
                <option value="Drama" <?php if(htmlspecialchars($movie['genre']) === 'Drama'): ?> selected <?php endif ?>>Drama</option>
                <option value="Sci-Fi" <?php if(htmlspecialchars($movie['genre']) === 'Sci-Fi'): ?> selected <?php endif ?>>Sci-Fi</option>
                <option value="Comedy" <?php if(htmlspecialchars($movie['genre']) === 'Comedy'): ?> selected <?php endif ?>>Comedy</option>
                <option value="Rom-com" <?php if(htmlspecialchars($movie['genre']) === 'Rom-com'): ?> selected <?php endif ?>>Rom-com</option>
                <option value="Horror" <?php if(htmlspecialchars($movie['genre']) === 'Horror'): ?> selected <?php endif ?>>Horror</option>
                <option value="Mystery" <?php if(htmlspecialchars($movie['genre']) === 'Mystery'): ?> selected <?php endif ?>>Mystery</option>
                <option value="Adventure" <?php if(htmlspecialchars($movie['genre']) === 'Adventure'): ?> selected <?php endif ?>>Adventure</option>
            </select>
        </div>
        <div>
            <label for="rating">Rating</label>
            <input id="rating" name="rating" type="number" step="0.1" min="1" max="10" required value="<?php echo htmlspecialchars($movie['rating'])?>">
        </div>
        <div>
            <label for="date">Date</label>
            <input id="date" name="date" type="date" required value="<?php echo htmlspecialchars($movie['date'])?>">
        </div>
        <div>
            <label for="description">Description</label>
            <input id="description" name="description" type="text" required value="<?php echo htmlspecialchars($movie['description'])?>">
        </div>
        <input type="hidden" name="username" value="<?= htmlspecialchars($user) ?>">
        <button type="submit">Edit movie review</button>
    </form>
<?php endif ?>