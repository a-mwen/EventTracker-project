<?php
include 'conn.php';

try {
    // Create a new PDO connection to PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch relevant metrics from the data
    $sql = "SELECT action_type, action_description, device_type, browser_info, geolocation, ip_address, duration FROM user_metrics";
    $stmt = $pdo->query($sql);
    $metrics = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the metrics as JSON
    header('Content-Type: application/json');
    echo json_encode($metrics);
} catch (PDOException $e) {
    // If connection fails, show an error message
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}
?>