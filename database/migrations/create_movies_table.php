<?php
require 'database/db.php';

$db = connectDb();

$queryMovies = <<<SQL
CREATE TABLE IF NOT EXISTS movies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    director TEXT NOT NULL,
    genre TEXT NOT NULL,
    rating REAL NOT NULL,
    date DATE NOT NULL,
    description TEXT NOT NULL,
    username TEXT NOT NULL
);
SQL;

if($db->exec($queryMovies)){
    echo "Table 'movies' created successfully";
} else {
    echo "Error creating table 'movies': ".$db->lastErrorMsg();
}

$db->close();
?>