<?php
require 'db_connect.php';

$pdo = connectDB();

$events_query = <<<SQL
CREATE TABLE IF NOT EXISTS events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    event_name TEXT NOT NULL,
    event_date DATE NOT NULL,
    event_venue TEXT NOT NULL,
    total_tickets INTEGER NOT NULL,
    reserved_tickets INTEGER NOT NULL
)
SQL;

$reservations_query = <<<SQL
CREATE TABLE IF NOT EXISTS reservations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    user_tickets INTEGER NOT NULL,
    event_id INTEGER NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) ON UPDATE CASCADE ON DELETE CASCADE
)
SQL;

$pdo->exec($events_query);
$pdo->exec($reservations_query);

?>