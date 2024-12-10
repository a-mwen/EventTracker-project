<?php
// Include database connection
require_once 'connection.php'; // Adjust the path as necessary

// Initialize message variable
$message = "";

// Function to delete duplicate attendees
function deleteDuplicateAttendees($pdo) {
    $query = "DELETE FROM attendees
              WHERE id NOT IN (
                  SELECT MIN(id)
                  FROM attendees
                  GROUP BY user_id, event_id
              )";
    
    $stmt = $pdo->prepare($query);
    
    if ($stmt->execute()) {
        return "Duplicate attendees deleted successfully!";
    } else {
        return "Error deleting duplicates: " . implode(", ", $stmt->errorInfo());
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the delete duplicates button was pressed
    if (isset($_POST['delete_duplicates'])) {
        $message = deleteDuplicateAttendees($pdo);
    }
}

// Fetch attendees to display, including username from users table
$query = "
    SELECT a.id, a.user_id, a.event_id, u.username 
    FROM attendees a
    JOIN users u ON a.user_id = u.id"; // Assuming 'users' table has 'id' and 'username' columns
$stmt = $pdo->prepare($query);
$stmt->execute();
$attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendees</title>
    <link rel="stylesheet" href="../public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <div class="container">
        <h1>Manage Attendees</h1>
        
        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <h2>Current Attendees</h2>
        <table class="attendees-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Event ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendees as $attendee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($attendee['id']); ?></td>
                        <td><?php echo htmlspecialchars($attendee['username']); ?></td>
                        <td><?php echo htmlspecialchars($attendee['event_id']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="POST" action="" class="delete-duplicates-form">
            <h2>Delete Duplicate Attendees</h2>
            <button type="submit" name="delete_duplicates" class="delete-button">Delete Duplicates</button>
        </form>

        <div class="back-button">
            <a href="../authentication/welcome.php" class="back-link">Back to Welcome Page</a> <!-- Adjust the path as necessary -->
        </div>

    </div>
    <div class="chat-icon" style="position: fixed; bottom: 20px; right: 20px;">
                <a href="../Chatbot/index.php" style="text-decoration: none;">
                    <div style="background-color: #007bff; color: white; border-radius: 50%; width: 40px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: background-color 0.3s;">
                    <i class="fas fa-comments" style="font-size: 24px;"></i>
            </div>
</body>
</html>