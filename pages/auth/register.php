<?php
session_start();
require '../../jwt_helper.php';

if(isset($_SESSION['token']) && decodeJWT($_SESSION['token'])){
    header("Location: ../../index.php");
}

?>

<form method="post" action="../../handlers/auth/register_handler.php">
    <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
    </div>
    <button type="submit">Register</button>
    <p>Already have an account?</p><a href="login.php">Log in here</a>
</form>
