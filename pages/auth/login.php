<?php
session_start();
require '../../jwt_helper.php';
if (isset($_SESSION['token']) && decodeJWT($_SESSION['token'])) {
    header("Location: ../../index.php");
}
?>


<form method="post" action="../../handlers/auth/login_handler.php">
    <div>
        <label>Username</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Log in</button>
    <p>Don't have an account?</p><a href="register.php">Register here</a>
</form>
