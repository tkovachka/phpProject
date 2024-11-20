<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["event_id"]) && isset($_GET["username"])) {
    $event_id = intval($_GET["event_id"]);
    $username = $_GET["username"];

    $pdo = connectDB();

    $query = "SELECT * FROM events WHERE id = :event_id";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute(["event_id" => $event_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error getting event: " . $e->getMessage();
    }
}

?>


<form method="post" action="reserve_handler.php">
    <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
    <input type="hidden" name="event_id" value="<?= htmlspecialchars($event_id) ?>">
    <div>
        <label for="event">Event</label>
        <input id="event" readonly type="text"
               value="<?= htmlspecialchars($event['event_name']), htmlspecialchars($event['event_date']) ?>">
    </div>
    <div>
        <label for="user_tickets">Number of tickets</label>
        <input name="user_tickets" id="user_tickets" type="number" max="5" step="1">
    </div>
    <button type="submit">Reserve</button>
</form>