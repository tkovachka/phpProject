<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);

    $pdo = connectDB();

    $query = <<<SQL
DELETE FROM events WHERE id = :id;
SQL;

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([":id" => $id]);
        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Error deleting event:" . $e->getMessage();
    }

}

?>