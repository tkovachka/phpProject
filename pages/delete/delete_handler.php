<?php
session_start();
require '../../db.php';
require '../../jwt_helper.php';

if (!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header('Location: ../../auth/login_form.php');
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    $expense = null;

    $query = "SELECT * FROM expenses WHERE id = :id";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        $expense = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        "Error getting expense: " . $e->getMessage();
    }
    if ($expense != null) {
        if($expense['amount'] >= 100){
            echo "Cannot delete expense, the amount is larger than 100.";
            exit;
        }
        $query = "DELETE FROM expenses WHERE id=:id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([":id" => $id]);
        header("Location: /pages/index/index.php");
    } else {
        "Error getting expense from database.";
    }
} else {
    echo "Invalid request";
}
exit;

