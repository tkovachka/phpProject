<?php
?>


<form method="post" action="create_handler.php">
    <div>
        <label for="event_name">Event Name</label>
        <input id="event_name" name="event_name" type="text" required>
    </div>
    <div>
        <label for="event_date">Event Date</label>
        <input id="event_date" name="event_date" type="date" required>
    </div>
    <div>
        <label for="event_venue">Event Venue</label>
        <input id="event_venue" name="event_venue" type="text" required>
    </div>
    <div>
        <label for="total_tickets">Total Tickets</label>
        <input id="total_tickets" name="total_tickets" type="number" required>
    </div>
    <button type="submit">Create new event</button>
</form>
