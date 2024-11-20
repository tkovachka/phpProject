<?php
function connectDB()
{
    try {
        $dsn = 'sqlite:' . __DIR__ . '/database.sqlite';
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    } catch (PDOException $e) {
        die ("Error connecting to database: " . $e->getMessage());
    }
}

?>