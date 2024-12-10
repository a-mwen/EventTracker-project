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

    // Fetch the user ID based on the username
    $query = "SELECT id FROM users WHERE username = :username"; // Assuming you have a users table
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $user_id = $user['id']; // Get user ID from the fetched user data

        // Check if the event is in the future
        $eventQuery = "SELECT event_date FROM events WHERE id = :event_id";
        $eventStmt = $pdo->prepare($eventQuery);
        $eventStmt->bindParam(':event_id', $event_id);
        $eventStmt->execute();
        $event = $eventStmt->fetch(PDO::FETCH_ASSOC);

        if ($event) {
            // Check if the event date is in the past
            if (strtotime($event['event_date']) < time()) {
                $message = "You cannot register for an event that has already occurred.";
            } else {
                // Check if the user is already registered for the event
                $checkQuery = "SELECT COUNT(*) FROM attendees WHERE user_id = :user_id AND event_id = :event_id";
                $checkStmt = $pdo->prepare($checkQuery);
                $checkStmt->bindParam(':user_id', $user_id);
                $checkStmt->bindParam(':event_id', $event_id);
                $checkStmt->execute();
                $count = $checkStmt->fetchColumn();

                if ($count > 0) {
                    $message = "You are already registered for this event.";
                } else {
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
                }
            }
        } else {
            $message = "Event not found.";
        }
    } else {
        $message = "User  not found.";
    }
}

// Fetch upcoming events for the dropdown
$query = "SELECT id, event_name FROM events WHERE event_date >= NOW()"; // Only upcoming events
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <div class="container">
        <h1>Register for an Event</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! Please select an event from the list below to register.</p>
        
        <div class="description">
            <p>This page allows you to register for various events organized by our platform. By registering, you will secure your spot and receive updates about the event. Please choose an event from the dropdown menu and click the "Register" button to confirm your participation. If you have any questions, feel free to reach out to our support team.</p>
        </div>

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

        <div class="back-button">
            <a href="../authentication/welcome.php" class="back-link">Back to Welcome Page</a> <!-- Adjust the path as necessary -->
        </div>


    </div>
    <div class="chat-icon" style="position: fixed; bottom: 20px; right: 20px;">
                <a href="../Chatbot/index.php" style="text-decoration: none;">
                    <div style="background-color: #007bff; color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: background-color 0.3s;">
                        <i class="fas fa-comments" style="font-size: 24px;"></i>
            </div>
</body>
</html>