<!-- execute once to create the database -->
<?php
$dsn = 'sqlite:' . __DIR__ . '/database/database.sqlite';
try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$query = 'CREATE TABLE IF NOT EXISTS expenses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    date DATE NOT NULL,
    amount INTEGER NOT NULL,
    payment_method TEXT NOT NULL
    )';

$queryUsers = 'CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    password TEXT NOT NULL
    )';

$pdo->exec($query);
$pdo->exec($queryUsers);