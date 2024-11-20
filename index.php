<?php
require "create_tables.php";

$pdo = connectDb();

$query = "SELECT * FROM events";
$result = $pdo->query($query);
$events = $result->fetchAll(PDO::FETCH_ASSOC);

//todo implement getting username from session token
$user = null;

?>

<form method="get" action="create_form.php">
    <button type="submit">Create new event</button>
</form>
<table>
    <thead>
    <tr>
        <th>Event Name</th>
        <th>Event Date</th>
        <th>Event Venue</th>
        <th>Total Tickets</th>
        <th>Tickets Reserved</th>
        <th>Tickets Remaining</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($events): ?>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['event_name']) ?></td>
                <td><?= htmlspecialchars($event['event_date']) ?></td>
                <td><?= htmlspecialchars($event['event_venue']) ?></td>
                <td><?= htmlspecialchars($event['total_tickets']) ?></td>
                <td><?= htmlspecialchars($event['reserved_tickets']) ?></td>
                <td><?= (htmlspecialchars($event['total_tickets']- $event['reserved_tickets'])) ?></td>
                <td>
                    <form method="get" action="edit_form.php" style="display: inline-block">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form method="post" action="delete_handler.php" style="display: inline-block">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form method="get" action="reserve_form.php" style="display: inline-block">
                        <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">
                        <input type="hidden" name="username" value="<?= htmlspecialchars($user) ?? "" ?>">
                        <button type="submit">Reserve tickets</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
