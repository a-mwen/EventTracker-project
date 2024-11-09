<?php
session_start();
// Check if the user is logged in, if not redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include 'connection.php';

// Fetch events from the database
$query = "SELECT * FROM events";
$stmt = $pdo->query($query);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <div class="event-container">
        <h1>Event Management</h1>
        <p><a href="addevent.php">Add New Event</a></p> <!-- Link to Add Event -->

        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                        <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                        <td><?php echo htmlspecialchars($event['location']); ?></td>
                        <td><?php echo htmlspecialchars($event['description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Navigation Buttons -->
        <div class="navigation-buttons">
            <a href="../public/product.php" class="nav-button">View Products</a>
            <a href="../authentication/welcome.php" class="nav-button">Back to Welcome</a>
        </div>
    </div>
</body>
</html>