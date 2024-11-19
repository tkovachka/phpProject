<?php
require 'database/db.php';

$db = connectDb();

$queryUsers = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
);
SQL;


if($db->exec($queryUsers)){
    echo "Table 'users' created successfully";
} else {
    echo "Error creating table 'users': ".$db->lastErrorMsg();
}

$db->close();

?>