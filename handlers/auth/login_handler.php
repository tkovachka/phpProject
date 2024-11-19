<?php
session_start();
require '../../database/db.php';
require '../../jwt_helper.php';

if (isset($_SESSION['token']) && decodeJwt($_SESSION['token'])) {
    header("Location: ../../index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $db = connectDb();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $token = createJWT($user['id'], $username);
            session_regenerate_id(true);
            $_SESSION['token'] = $token;

            header("Location: ../../index.php");
        } else {
            echo "Incorrect password. <a href='../../pages/auth/login.php'>Try again?</a>";
        }
    } else {
        echo "User doesn't exist";
    }

    $db->close();
}
?>
