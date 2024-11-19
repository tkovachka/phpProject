<?php
function connectDb(): SQLite3{
    return new SQLite3(__DIR__.'/db.sqlite');
}

?>
