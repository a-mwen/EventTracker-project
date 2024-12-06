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
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 10px;
        }
        .intro {
            text-align: center;
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            width: 200px;
            transition: transform 0.3s, box-shadow 0.3s;
            color: #333;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }
        .card i {
            font-size: 40px;
            color: #6a11cb;
            margin-bottom: 10px;
        }
        a {
            display: block;
            margin-top: 10px;
            padding: 10px;
            background-color: #6a11cb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #2575fc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Our Event Management System</h1>
        <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div class="intro">
            <p>We are glad to have you here. Explore our features below!</p>
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
        </div>
    </div>
    
    <form action="logout.php" method="post" style="text-align: center; margin-top: 20px;">
        <button type="submit">Logout</button>
    </form>
</body>
</html>