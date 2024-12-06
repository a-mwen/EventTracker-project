<?php
include 'conn.php';

try {
    // Create a new PDO connection to PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, show an error message
    die("Connection failed: " . $e->getMessage());
}

// Process form if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $actionType = $_POST['action_type'];
    $actionDescription = $_POST['action_description'];
    $deviceType = $_POST['device_type'];
    $browserInfo = $_POST['browser_info'];
    $geolocation = $_POST['geolocation'];
    $ipAddress = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
    $duration = $_POST['duration'];

    $sql = "INSERT INTO user_metrics (user_id, action_type, action_description, device_type, browser_info, geolocation, ip_address, duration) 
            VALUES (:user_id, :action_type, :action_description, :device_type, :browser_info, :geolocation, :ip_address, :duration)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':user_id' => 1, // Replace with actual user ID if available
        ':action_type' => $actionType,
        ':action_description' => $actionDescription,
        ':device_type' => $deviceType,
        ':browser_info' => $browserInfo,
        ':geolocation' => $geolocation,
        ':ip_address' => $ipAddress,
        ':duration' => $duration
    ));

    echo "Metric added successfully!";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stylesheets/metrics.css">
    <title>Add Metrics - EventTrack</title>
</head>
<body>
    <header>
        <h1>Add Metrics</h1>
    </header>
    <div class="container">
        <form method="post" action="">
            <label for="action_type">Action Type:</label>
            <input type="text" name="action_type" id="action_type" required>

            <label for="action_description">Action Description:</label>
            <input type="text" name="action_description" id="action_description" required>

            <label for="device_type">Device Type:</label>
            <input type="text" name="device_type" id="device_type" required>

            <label for="browser_info">Browser Info:</label>
            <input type="text" name="browser_info" id="browser_info" required>

            <label for="geolocation">Geolocation:</label>
            <input type="text" name="geolocation" id="geolocation" required>

            <label for="duration">Duration (in seconds):</label>
            <input type="number" name="duration" id="duration" step="0.01" required>

            <button type="submit">Submit</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2023 EventTrack. All rights reserved.</p>
    </footer>
</body>
</html>