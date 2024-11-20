<?php

session_start();
require '../../jwt_helper.php';

if (!isset($_SESSION['token']) || !decodeJWT($_SESSION['token'])) {
    header("Location: ../../index.php");
}

session_unset();

session_destroy();

header("Location: ../../index.php")

?>
