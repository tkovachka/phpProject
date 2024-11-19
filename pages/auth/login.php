<?php
session_start();
require '../../jwt_helper.php';

if(isset($_SESSION['token']) && decodeJWT($_SESSION['token'])){
    header("Location: ../../index.php");
}

?>

<form method="post" action="../../handlers/auth/login_handler.php">
    <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
    </div>
    <button type="submit">Log in</button>
    <p>Don't have an account?</p><a href="register.php">Register here</a>
</form>
