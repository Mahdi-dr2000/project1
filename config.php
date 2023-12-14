<?php

$host = 'localhost';
$dbname = '6tasks';
$username = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $pass);
} catch (PDOException $e) {
    echo "Error " . $e->getMessage();
}
