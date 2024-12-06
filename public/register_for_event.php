<?php 
session_start();

// Check if the user is logged in using username
if (!isset($_SESSION['username'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include_once __DIR__ . '/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['event_id'];
    $username = $_SESSION['username']; // Retrieve username from session

    // You may need to fetch the user ID based on the username if needed
    $query = "SELECT id FROM users WHERE username = :username"; // Assuming you have a users table
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $user_id = $user['id']; // Get user ID from the fetched user data

        // Insert attendee into the database
        $query = "INSERT INTO attendees (user_id, event_id, registration_date) VALUES (:user_id, :event_id, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':event_id', $event_id);
        
        if ($stmt->execute()) {
            $message = "Successfully registered for the event!";
        } else {
            $message = "Error registering for the event: " . implode(", ", $stmt->errorInfo());
        }
    } else {
        $message = "User  not found.";
    }
}

// Fetch events for the dropdown
$query = "SELECT id, event_name FROM events";
$stmt = $pdo->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Event</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <div class="container">
        <h1>Register for an Event</h1>
        <?php if (isset($message)): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="register_for_event.php" method="post">
            <label for="event_id">Select Event:</label>
            <select name="event_id" id="event_id" required>
                <option value="">-- Select an Event --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['event_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="register-button">Register</button>
        </form>
        <div>
            <a href="../authentication/welcome.php" class="back-link">Back to Welcome Page</a>
        </div>
    </div>
</body>
</html>