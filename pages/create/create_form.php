<?php
session_start();
require '../../jwt_helper.php';
if(!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: ../../auth/login_form.php');
    exit;
}
?>
<form method="post" action="create_handler.php">
    <label for="name">Name</label><br>
    <input type="text" id="name" name="name" required/><br>
    <label for="date">Date</label><br>
    <input type="date" id="date" name="date" required/><br>
    <label for="amount">Amount</label><br>
    <input type="number" id="amount" name="amount" required/><br>
    <label for="payment_method">Payment method</label><br>
    <input type="radio" id="payment_cash" name="payment_method" value="Cash">
    <label for="payment_cash">Cash</label>
    <input type="radio" id="payment_card" name="payment_method" value="Card">
    <label for="payment_card">Card</label><br>
    <button type="submit">Create new expense</button>
</form>