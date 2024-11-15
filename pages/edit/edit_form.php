<?php
session_start();
require '../../db.php';
require '../../jwt_helper.php';

if (!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: ../../auth/login_form.php');
    exit;
}

$expense = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM expenses WHERE id = :id";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        $expense = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        "Error getting expense: " . $e->getMessage();
    }
}
?>
<?php if ($expense != null): ?>
<form method="post" action="edit_handler.php">
    <label for="name">Name</label><br>
    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($expense['name']) ?>"/><br>
    <label for="date">Date</label><br>
    <input type="date" id="date" name="date" required value="<?= htmlspecialchars($expense['date']) ?>"/><br>
    <label for="amount">Amount</label><br>
    <input type="number" id="amount" name="amount" required value="<?= htmlspecialchars($expense['amount']) ?>"/><br>
    <label for="payment_method">Payment method</label><br>
    <input type="radio" id="payment_cash" name="payment_method" value="Cash"
        <?php if(htmlspecialchars($expense['payment_method'] === "Cash")): ?>
        checked
        <?php endif ?>
    >
    <label for="payment_cash">Cash</label>
    <input type="radio" id="payment_card" name="payment_method" value="Card"
        <?php if(htmlspecialchars($expense['payment_method'] === "Card")): ?>
            checked
        <?php endif ?>
    >
    <label for="payment_card">Card</label><br>
    <input type="hidden" name="id" value="<?= htmlspecialchars($expense['id']) ?>">
    <button type="submit">Update new expense</button>
</form>
<?php else: ?>
<p>Expense not found</p>
<?php endif ?>