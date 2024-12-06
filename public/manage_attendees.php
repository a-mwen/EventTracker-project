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
    } elseif (isset($_POST['attendee_id'])) {
        // Update existing attendee
        $attendee_id = $_POST['attendee_id'];
        $event_id = 1; // Use the existing event ID
        $status = $_POST['status'];

        // Prepare the SQL update query
        $query = "UPDATE attendees SET event_id = :event_id, status = :status WHERE id = :attendee_id";
        $stmt = $pdo->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':attendee_id', $attendee_id);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            $message = "Attendee updated successfully!";
        } else {
            $message = "Error updating attendee: " . implode(", ", $stmt->errorInfo());
        }
    }
}

// Fetch attendees to display (optional)
$query = "SELECT * FROM attendees";
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
    <link rel="stylesheet" href="styles.css"> <!-- Adjust the path as necessary -->
</head>
<body>
    <div class="container">
        <h1>Manage Attendees</h1>
        
        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <h2>Current Attendees</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Event ID</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendees as $attendee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($attendee['id']); ?></td>
                        <td><?php echo htmlspecialchars($attendee['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($attendee['event_id']); ?></td>
                        <td><?php echo htmlspecialchars($attendee['status']); ?></td>
                        <td>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="attendee_id" value="<?php echo htmlspecialchars($attendee['id']); ?>">
                                <select name="status">
                                    <option value="Pending" <?php echo $attendee['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Confirmed" <?php echo $attendee['status'] === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="Cancelled" <?php echo $attendee['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="POST" action="" class="delete-duplicates-form">
            <h2>Delete Duplicate Attendees</h2>
            <button type="submit" name="delete_duplicates">Delete Duplicates</button>
        </form>

        <!-- Back to Welcome Page Button -->
        < <div class="back-button">
            <a href="../authentication/welcome.php" class="back-link">Back to Welcome Page</a> <!-- Adjust the path as necessary -->
        </div>
    </div>
</body>
</html>