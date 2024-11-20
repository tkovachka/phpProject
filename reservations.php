<?php
require "db_connect.php";

$pdo = connectDb();

$query = "SELECT * FROM reservations";
$result = $pdo->query($query);
$reservations = $result->fetchAll(PDO::FETCH_ASSOC);
$event_names = array(PDO::FETCH_ASSOC);

foreach ($reservations as $reservation) {
    $query = "SELECT * FROM events WHERE id = :event_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['event_id' => $reservation['event_id']]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    array_push($event_names, $event['event_name']);
}

//todo implement getting username from session token
$user = null;

?>

<table>
    <thead>
    <tr>
        <th>Event Name</th>
        <th>Username</th>
        <th>Users Tickets Reserved</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($reservations): $i = 0; ?>
        <?php foreach ($reservations as $event): ?>
            <tr>
                <td><?= $event_names[$i++] ?? "" ?></td>
                <td><?= htmlspecialchars($reservation['username']) ?? "" ?></td>
                <td><?= htmlspecialchars($reservation['user_tickets']) ?? 0 ?></td>
<!--                <td>-->
<!--                    <form method="get" action="edit_form.php" style="display: inline-block">-->
<!--                        <input type="hidden" name="id" value="--><?php //= htmlspecialchars($event['id']) ?><!--">-->
<!--                        <button type="submit">Edit</button>-->
<!--                    </form>-->
<!--                    <form method="post" action="delete_handler.php" style="display: inline-block">-->
<!--                        <input type="hidden" name="id" value="--><?php //= htmlspecialchars($event['id']) ?><!--">-->
<!--                        <button type="submit">Delete</button>-->
<!--                    </form>-->
<!--                    <form method="get" action="reserve_form.php" style="display: inline-block">-->
<!--                        <input type="hidden" name="event_id" value="--><?php //= htmlspecialchars($event['id']) ?><!--">-->
<!--                        <input type="hidden" name="username" value="--><?php //= htmlspecialchars($user) ?? "" ?><!--">-->
<!--                        <button type="submit">Delete</button>-->
<!--                    </form>-->
<!--                </td>-->
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<a href="index.php">Back to events</a>
