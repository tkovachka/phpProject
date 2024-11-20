<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $pdo = connectDB();

    $query = <<<SQL
SELECT * FROM events WHERE id=:id
SQL;
    $stmt = $pdo->prepare($query);
    try{
        $stmt->execute(["id" => $id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error getting event: ".$e->getMessage();
        exit;
    }
} else {
    header("Location: index.php");
}
?>
<form method="post" action="edit_handler.php">
    <div>
        <label for="event_name">Event Name</label>
        <input id="event_name" name="event_name" type="text" required
               value="<?= htmlspecialchars($event['event_name']) ?? "" ?>">
    </div>
    <div>
        <label for="event_date">Event Date</label>
        <input id="event_date" name="event_date" type="date" required
               value="<?= htmlspecialchars($event['event_date']) ?? "" ?>">
    </div>
    <div>
        <label for="event_venue">Event Venue</label>
        <input id="event_venue" name="event_venue" type="text" required
               value="<?= htmlspecialchars($event['event_venue']) ?? "" ?>">
    </div>
    <div>
        <label for="total_tickets">Total Tickets</label>
        <input id="total_tickets" name="total_tickets" type="number" required
               value="<?= htmlspecialchars($event['total_tickets']) ?? 0 ?>">
    </div>
    <input type="hidden" name="reserved_tickets" value="<?= htmlspecialchars($event['reserved_tickets']) ?? 0 ?>">
    <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?? 0 ?>">
    <button type="submit">Save event</button>
</form>
