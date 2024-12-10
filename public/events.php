<?php
session_start();
// Check if the user is logged in, if not redirect to login
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

// Set the number of events to display per page
$events_per_page = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $events_per_page;

// Fetch total events to calculate total pages
$total_query = "SELECT COUNT(*) FROM events WHERE status = 'upcoming'";
$total_stmt = $pdo->query($total_query);
$total_events = $total_stmt->fetchColumn();
$total_pages = ceil($total_events / $events_per_page);

// Fetch events for the current page
$query = "SELECT * FROM events WHERE status = 'upcoming' LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':limit', $events_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="../public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                <?php if (count($events) > 0): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                            <td><?php echo htmlspecialchars($event['location']); ?></td>
                            <td><?php echo htmlspecialchars($event['description']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No upcoming events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php if ($current_page > 1): ?>
                <a href="?page=<?php echo $current_page - 1; ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($i === $current_page) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?php echo $current_page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>

        <!-- Navigation Buttons -->
        <div class="navigation-buttons">
            <a href="../authentication/welcome.php" class="nav-button">Back to Welcome</a>
        </div>
    </div>
    <div class="chat-icon" style="position: fixed; bottom: 20px; right: 20px;">
        <a href="../Chatbot/index.php" style="text-decoration: none;">
            <div style="background-color: #007bff; color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: background-color 0.3s;">
                <i class="fas fa-comments" style="font-size: 24px;"></i>
            </div>
        </a>
    </div>
</body>
</html>
