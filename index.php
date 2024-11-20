<?php
session_start();
require 'db_connection.php';
require 'jwt_helper.php';

$authorized=false;
if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])){
    header ("Location: /pages/auth/login.php");
} else {
    $authorized=true;
}

$db = connect_database();

$query = "SELECT * FROM notes";
$notes = $db->query($query);

?>
<form method="get" action="/pages/create_form.php" style="display: inline">
    <button type="submit">Create new note</button>
</form>
<table>
    <thead>
    <tr>
        <th>Username</th>
        <th>Note title</th>
        <th>Note content</th>
        <th>Date created</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($notes): ?>
    <?php while ($note = $notes->fetchArray(SQLITE3_ASSOC)): ?>
        <tr>
            <td><?= htmlspecialchars($note['username']) ?></td>
            <td><?= htmlspecialchars($note['title']) ?></td>
            <td><?= htmlspecialchars($note['content']) ?></td>
            <td><?= htmlspecialchars($note['date_created']) ?></td>
            <td>
                <form method="get" action="/pages/edit_form.php" style="display: inline">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($note['id']) ?>">
                    <button type="submit">Edit</button>
                </form>
                <form method="post" action="/handlers/delete_handler.php" style="display: inline">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($note['id']) ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    <?php endif; ?>
    </tbody>
</table>
<?php if($authorized): ?>
<a href="handlers/auth/logout_handler.php">Log out</a>
<?php else: ?>
<a href="pages/auth/login.php">Log in</a>
<a href="pages/auth/register.php">Register</a>
<?php endif; ?>

