<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_venue = $_POST['event_venue'];
    $total_tickets = intval($_POST['total_tickets']);
    $reserved_tickets = 0;

    $pdo = connectDB();

    $query = <<<SQL
INSERT INTO events (event_name, event_date, event_venue, total_tickets, reserved_tickets) VALUES (:event_name, :event_date, :event_venue, :total_tickets, :reserved_tickets)
SQL;

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':event_name' => $event_name,
            ':event_date' => $event_date,
            ':event_venue' => $event_venue,
            ':total_tickets' => $total_tickets,
            ':reserved_tickets' => $reserved_tickets
        ]);

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error saving new event: " . $e->getMessage();
    }
}

?>
