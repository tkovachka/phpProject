<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["id"]);
    $event_name = $_POST["event_name"];
    $event_date = $_POST["event_date"];
    $event_venue = $_POST['event_venue'];
    $total_tickets = intval($_POST['total_tickets']);
    $reserved_tickets = intval($_POST['reserved_tickets']);

    $pdo = connectDB();

    $query = <<<SQL
UPDATE events SET event_name = :event_name, event_date = :event_date, event_venue = :event_venue, total_tickets = :total_tickets, reserved_tickets = :reserved_tickets WHERE id = :id;
SQL;

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':event_name' => $event_name,
            ':event_date' => $event_date,
            ':event_venue' => $event_venue,
            ':total_tickets' => $total_tickets,
            ':reserved_tickets' => $reserved_tickets,
            ':id' => $id
        ]);

        header("Location: index.php");

    } catch (PDOException $e) {
        echo "Error saving event to db: " . $e->getMessage();
    }

}


?>
