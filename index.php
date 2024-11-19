<?php
session_start();
require 'database/db.php';
require 'jwt_helper.php';

$authenticated = false;

if (isset($_SESSION['token']) && decodeJWT($_SESSION['token'])) {
    $authenticated = true;
}

$db = connectDb();

$query = "SELECT * FROM movies";

$movies = $db->query($query);

?>
<?php if ($authenticated): ?>
<form method="get" action="pages/add.php">
    <button type="submit">Add new review</button>
</form>
<?php endif?>
<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Director</th>
        <th>Genre</th>
        <th>Rating</th>
        <th>Date</th>
        <th>Description</th>
        <th>Username</th>
        <?php if ($authenticated): ?>
            <th>Actions</th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php if ($movies): ?>
        <?php while ($movie = $movies->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($movie['title']) ?></td>
                <td><?= htmlspecialchars($movie['director']) ?></td>
                <td><?= htmlspecialchars($movie['genre']) ?></td>
                <td><?= htmlspecialchars($movie['rating']) ?></td>
                <td><?= htmlspecialchars($movie['date']) ?></td>
                <td><?= htmlspecialchars($movie['description']) ?></td>
                <td><?= htmlspecialchars($movie['username']) ?></td>
                <?php if ($authenticated): ?>
                <td>
                    <form method="get" action="pages/edit.php" style="display: inline-block">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($movie['id'])?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form method="post" action="handlers/delete_handler.php" style="display: inline-block">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($movie['id'])?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
                <?php endif?>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
    </tbody>
</table>
<?php if (!$authenticated): ?>
    <a href="pages/auth/login.php">Log in</a>
    <a href="pages/auth/register.php">Register</a>
<?php else: ?>
    <a href="handlers/auth/logout_handler.php">Log out</a>
<?php endif ?>
