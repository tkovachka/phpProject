<?php
session_start();
require '../../jwt_helper.php';
if (isset($_SESSION['token']) && decodeJWT($_SESSION['token'])) {
    header("Location: ../../index.php");
}
?>


<form method="post" action="../../handlers/auth/register_handler.php">
    <div>
        <label>Username</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Register</button>
    <p>Already have an account?</p><a href="login.php">Log in here</a>
</form>
