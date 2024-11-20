<?php
session_start();

require '../../db_connection.php';
require '../../jwt_helper.php';

if (isset($_SESSION['token']) && decodeJWT($_SESSION['token'])) {
    header("Location: ../../index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $db = connect_database();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
    if($user){
        if(password_verify($password, $user['password'])){
            $token = createJWT($user['id'],$user['username']);

            session_regenerate_id(true);

            $_SESSION['token'] = $token;

            header("Location: ../../index.php");

        }else{
            echo "Wrong password";
        }
    }else{
        echo "User doesn't exist.<a href='../../pages/auth/register.php'>Register here</a>";
    }
}

?>