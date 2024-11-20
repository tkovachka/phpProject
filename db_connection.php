<?php

function connect_database(): SQLite3{
    return new SQLite3(__DIR__ . "/notes_database.sqlite");
}

?>
