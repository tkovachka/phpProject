<?php
session_start();
require '../../db.php';
require '../../jwt_helper.php';

if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: ../auth/login_form.php');
    exit;
}

$stmt = $pdo->query('SELECT * FROM expenses');
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<form method="get" action="/pages/create/create_form.php">
    <button type="submit">Add new expense</button>
</form>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($expenses as $expense): ?>
            <tr>
                <td><?= htmlspecialchars($expense['name']) ?></td>
                <td><?= htmlspecialchars($expense['date']) ?></td>
                <td><?= htmlspecialchars($expense['amount']) ?></td>
                <td><?= htmlspecialchars($expense['payment_method']) ?></td>
                <td>
                    <form method="get" action="/pages/edit/edit_form.php">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($expense['id']); ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form method="post" action="/pages/delete/delete_handler.php">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($expense['id']); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="/auth/logout.php">Log out</a>
