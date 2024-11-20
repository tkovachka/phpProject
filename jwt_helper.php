<?php
require_once __DIR__ . "/vendor/autoload.php";

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv::createImmutable(__DIR__);

$dotenv->load();

function createJWT($userId, $username): string
{
    $secretKey = $_ENV['JWT_SECRET'];
    $payload = [
        'iss' => 'website_here',
        'aud' => 'website_here',
        'iat' => time(),
        'exp' => time() + 3600,
    ];

    return Firebase\JWT\JWT::encode($payload, $secretKey, 'HS256');
}


function decodeJWT($jwt)
{
    try {
        $jwtSecret = $_ENV['JWT_SECRET'];
        return JWT::decode($jwt, new Key($jwtSecret, 'HS256'));
    } catch (Exception $e) {
        return null;
    }
}

?>
