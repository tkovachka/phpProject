<form method="post" action="../../actions/auth/register_action.php">
    <label for="username">Username</label>
    <input type="text" required id="username" name="username"><br>
    <label for="password">Password</label>
    <input type="password" required id="password" name="password"><br>
    <label for="role">Role</label>
    <select name="role" id="role">
        <option value="Admin">Admin</option>
        <option value="User">User</option>
    </select><br>
    <button type="submit">Register</button>
    <p>Already have an account? <a href="login.php">Log in here</a></p>
</form>
