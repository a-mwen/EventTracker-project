<?php
session_start();
// Check if the user is logged in; if not, redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: ../authentication/login.php");
    exit();
}

// Include the database connection with an absolute path
include_once __DIR__ . '/connection.php';

// Verify if $pdo is defined before proceeding
if (!isset($pdo)) {
    die("Database connection not established.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Strict comparison
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $organizer_id = $_SESSION['user_id']; // Assuming you have user_id stored in session

    // Determine the status based on the event date
    $status = (strtotime($event_date) >= time()) ? 'upcoming' : 'past';

    // Insert event into the database
    $query = "INSERT INTO events (event_name, event_date, location, description, organizer_id, status) VALUES (:event_name, :event_date, :location, :description, :organizer_id, :status)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':event_date', $event_date);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':organizer_id', $organizer_id);
    $stmt->bindParam(':status', $status); // Bind the status parameter
    $stmt->execute();

    // Redirect to events page after adding
    header("Location: events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="../public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <h1>Add New Event</h1>
    <form method="POST" action="addevent.php">
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" required><br>

        <label for="event_date">Event Date:</label>
        <input type="datetime-local" name="event_date" required><br>

        <label for="location">Location:</label>
        <input type="text" name="location" required><br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>

        <button type="submit">Add Event</button>
    </form>

    <a href="events.php">Back to Events</a>

    <div class="chat-icon" style="position: fixed; bottom: 20px; right: 20px;">
                <a href="../Chatbot/index.php" style="text-decoration: none;">
                    <div style="background-color: #007bff; color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: background-color 0.3s;">
                        <i class="fas fa-comments" style="font-size: 24px;"></i>
            </div>
</body>
</html>