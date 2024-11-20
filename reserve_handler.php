<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["event_id"]) && isset($_POST["username"])) {
    $event_id = intval($_POST["event_id"]);
    $username = $_POST["username"];
    $user_tickets = intval($_POST["user_tickets"]);

    if ($user_tickets > 5) {
        echo "Cannot reserve more than 5 tickets per user";
        exit;
    }

    $pdo = connectDB();

    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = :event_id");
    $stmt->execute([':event_id' => $event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    $remaining_tickets = $event['total_tickets'] - $event['reserved_tickets'];
    if ($remaining_tickets - $user_tickets < 0) {
        echo "Not enough tickets, only " . $remaining_tickets . " tickets remaining. <a href='reserve_form.php'>Please try again</a>";
        exit;
    }

    $update_Query = <<<SQL
UPDATE events SET reserved_tickets = :reserved_tickets WHERE id = :event_id
SQL;

    try {
        $stmt = $pdo->prepare($update_Query);
        $stmt->execute([
            ":reserved_tickets" => $event['reserved_tickets'] + $user_tickets,
            ":event_id" => $event_id
        ]);
    } catch (PDOException $e) {
        echo "Error updating event tickets:" . $e->getMessage();
    }


    $query = <<<SQL
INSERT INTO reservations (event_id, username, user_tickets) VALUES (:event_id, :username, :user_tickets)
SQL;

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ":event_id" => $event_id,
            ":username" => $username,
            ":user_tickets" => $user_tickets
        ]);

        header("Location: reservations.php");

    } catch (PDOException $e) {
        echo "Error saving reservation: " . $e->getMessage();
    }
}

?>
