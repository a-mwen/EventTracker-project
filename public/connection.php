<?php
$host = 'localhost';
$db = 'project-WAD';
$user = 'postgres';
$pass = '317!!Musha4lyf';
$port = '5437'; 

try {
    // Create a new PDO connection to PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, show an error message
    die("Connection failed: " . $e->getMessage());
}
