<?php 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="../public/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ffffff, #e0f7fa);
            color: #333;
            margin: 0;
            padding: 20px;
            position: relative;
            overflow-y: auto; /* Allow vertical scrolling */
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
        h1 {
            text-align: center;
            font-size: 3em;
            margin-bottom: 20px;
            color: #007bff; /* Blue color for headings */
        }
        h2 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #007bff; /* Blue color for subheadings */
        }
        .intro {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 30px;
        }
        .card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px; /* Added margin for spacing */
        }
        .card {
            background: #007bff; /* Blue background for cards */
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            width: 220px;
            transition: transform 0.3s, box-shadow 0.3s;
            color: white; /* White text for cards */
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }
        .card i {
            font-size: 50px;
            margin-bottom: 10px;
        }
        a {
            display: block;
            margin-top: 10px;
            padding: 10px;
            background-color: #0056b3; /* Darker blue for links */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #004494; /* Even darker blue on hover */
        }
        .additional-info {
            text-align: center;
            margin-top: 30px;
            font-size: 1.2em;
        }
        .calendar-section {
            margin-top: 40px;
            text-align: center;
        }
 .calendar-section h2 {
            margin-bottom: 20px;
        }
        .event-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center align the event list */
        }
        .event-list li {
            background: rgba(0, 123, 255, 0.1); /* Light blue background for events */
            margin: 10px 0;
            padding: 15px;
            border-radius: 10px;
            transition: background 0.3s;
            width: 80%; /* Set a width for the event list items */
            max-width: 600px; /* Max width for larger screens */
            text-align: left; /* Align text to the left */
        }
        .event-list li:hover {
            background: rgba(0, 123, 255, 0.2); /* Darker blue on hover */
        }
        /* Background animation */
        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            animation: move 10s linear infinite;
            z-index: 0;
        }
        @keyframes move {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }
        /* Logout button styling */
        .logout-button {
            padding: 10px 20px;
            background-color: #ff4d4d; /* Red background for logout button */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            margin-top: 20px;
            transition: background-color 0.3s;
            z-index: 1; /* Ensure it appears above other elements */
        }
        .logout-button:hover {
            background-color: #cc0000; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <div class="background-animation"></div>
    <div class="container">
        <h1>Welcome to EventTracker</h1>
        <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div class="intro">
            <p>We are thrilled to have you here. Dive into our features below!</p>
        </div>

        <div class="card-container">
            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3><a href="../public/register_for_event.php">Register for an Event</a></h3>
            </div>
            <div class="card">
                <i class="fas fa-users"></i>
                <h3><a href="../public/manage_attendees.php">Manage Attendees</a></h3>
            </div>
            <div class="card">
                <i class="fas fa-box"></i>
                <h3><a href="../public/product.php">View Products</a></h3>
            </div>
            <div class="card">
                <i class="fas fa-calendar-alt"></i>
                <h3><a href="../public/events.php">View Events</a></h3>
            </div>
            <div class="card">
        <i class="fas fa-chart-line"></i>
        <h3><a href="../MYMETRICS/view_metrics.php">View Metrics</a></h3>
    </div>
        </div>

        <div class="additional-info">
            <h2>Additional Information</h2>
            <p>Our platform allows you to easily manage events, track attendees, and view products all in one place.</p>
            <p>Stay updated with the latest events and announcements by checking our news section regularly. If you have any questions, feel free to reach out to our support team.</p>
            <p>Don't forget to explore our community forums where you can connect with other users and share your experiences!</p>
        </div>

        <div class="calendar-section">
            <h2>Upcoming Events</h2>
            <ul class="event-list">
                <?php if (!empty($events) && is_array($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($event['event_name']); ?></strong><br>
                            Date: <?php echo htmlspecialchars(date('F j, Y', strtotime($event['event_date']))); ?><br>
                            <em><?php echo htmlspecialchars($event['event_description']); ?></em>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No upcoming events found.</li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
    <br>
    <br>
    
    <form action="logout.php" method="post" style="text-align: center; size: 15cm;">
        <button type="submit" class="logout-button">Logout</button>
    </form>

    <!-- Chatbot Popup -->
<div id="chatbot-popup" style="display: none; position: fixed; bottom: 80px; right: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); width: 300px; max-height: 400px; overflow-y: auto; z-index: 100;">
    <div style="background-color: #007bff; color: white; padding: 10px; border-radius: 10px 10px 0 0; font-size: 18px;">
        Chatbot
        <span style="float: right; cursor: pointer;" onclick="document.getElementById('chatbot-popup').style.display='none';">&times;</span>
    </div>
    <div style="padding: 10px;">
        <p>Hi! How can I assist you today?</p>
        <a href="../Chatbot/index.php" style="display: inline-block; padding: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Open Chatbot</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set timeout for 10 seconds (10000 milliseconds)
        setTimeout(() => {
            // Find the chatbot element and make it visible
            const chatbot = document.getElementById('chatbot-popup');
            if (chatbot) {
                chatbot.style.display = 'block';
            }
        }, 10000); // 10 seconds delay
    });
</script>


</body>
</html>