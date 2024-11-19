<?php
include 'database/db_connection.php';
include 'jwt_helper.php';

session_start();
$authenticated=false;
$isAdmin=false;

if (isset($_SESSION['token'])) {
    $decodedToken = decodeJWT($_SESSION['token']);
    if ($decodedToken) {
        $authenticated = true;
        if ($decodedToken->role === 'Admin')
            $isAdmin = true;
    }
}

$db = connectDatabase();

$query = "SELECT * FROM books";

$books = $db->query($query);
?>

<?php if ($authenticated): ?>
    <form method="get" action="pages/create.php">
        <button type="submit">Add new book</button>
    </form>
<?php endif; ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
            <th>ISBN</th><!--978-3-16-148410-0-->
            <?php if ($authenticated): ?>
                <th>Actions</th>
            <?php endif ?>
        </tr>
        </thead>
        <tbody>
        <?php while ($book = $books->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($book['id']) ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['genre']) ?></td>
                <td><?= htmlspecialchars($book['year']) ?></td>
                <td><?= htmlspecialchars($book['isbn']) ?></td>
                <td>
                    <?php if ($authenticated): ?>
                        <form method="get" action="pages/edit.php" style="display: inline-block">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                            <button type="submit">Edit</button>
                        </form>
                        <?php if ($isAdmin): ?>
                            <form method="post" action="actions/delete_action.php" style="display: inline-block">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                                <button type="submit">Delete</button>
                            </form>
                        <?php endif ?>
                    <?php endif ?>
                </td>
            </tr>
        <?php endwhile ?>
        </tbody>
    </table>
<?php if (!$authenticated): ?>
    <a href="pages/auth/login.php">Log in</a>
    <a href="pages/auth/register.php">Register</a>
<?php else: ?>
    <a href="actions/auth/logout_action.php">Log out</a>
<?php endif ?>