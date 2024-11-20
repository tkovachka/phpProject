<?php
require 'db_connection.php';

$db = connect_database();

$query = "CREATE TABLE IF NOT EXISTS notes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    date_created DATE NOT NULL
);";

$usersQuery = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
    )";

try {
    $db->exec($query);
    $db->exec($usersQuery);
    echo "Tables created successfully";
    $db->close();
} catch (PDOException $e) {
    die("Error creating table: " . $e->getMessage());
}
?>