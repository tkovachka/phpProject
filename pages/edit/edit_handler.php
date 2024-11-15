<?php
session_start();
require '../../db.php';
require '../../jwt_helper.php';

if (!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: ../../auth/login_form.php');
    exit;
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, "amount", FILTER_VALIDATE_INT);
    $payment_method = filter_input(INPUT_POST, "payment_method", FILTER_SANITIZE_STRING);

    if ($name && $date && $amount && $payment_method) {
        $query = 'UPDATE expenses SET name = :name, date = :date, amount = :amount, payment_method = :payment_method WHERE id = :id';

        try{
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':name' => $name,
                ':date' => $date,
                ':amount' => $amount,
                ':payment_method' => $payment_method,
                ':id' => $id
            ]);
            header("Location: /pages/index/index.php");
        } catch (PDOException $e) {
            echo "Error updating expense: ". $e->getMessage();
        }
    } else {
        echo "All fields are required";
    }
} else {
    header("Location: /pages/index/index.php");
}
