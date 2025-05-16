<?php
$host = "box5194.bluehost.com";
$db = "pllkqmmy_sabor_urbano";
$user = "pllkqmmy_administrador";
$pass = "x@b0rUrb4n0";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}
?>