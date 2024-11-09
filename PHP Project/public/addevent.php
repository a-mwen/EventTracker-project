<?php
session_start();
// Check if the user is logged in, if not redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include 'connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $organizer_id = $_SESSION['user_id']; // Assuming you have user_id stored in session

    // Insert event into the database
    $query = "INSERT INTO events (event_name, event_date, location, description, organizer_id) VALUES (:event_name, :event_date, :location, :description, :organizer_id)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':event_date', $event_date);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':organizer_id', $organizer_id);
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
</body>
</html>