<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}
session_start();

include '../functions/track_activity.php'; // Adjust path as needed

// Database Configuration
$host = 'localhost';
$db = 'project-WAD';
$user = 'postgres';
$pass = '317!!Musha4lyf';
$port = '5437';

// Create connection to Postgres
$conn = pg_connect("host=$host dbname=$db user=$user password=$pass port=$port");

// Check Connection
if ($conn === false) {
    die("Connection failed: " . pg_last_error());
} else {
    echo "Connection established";
}

// Get User Account Information
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE username=$1";
$result = pg_query_params($conn, $sql, array($username));

if ($result !== false) {
    if (pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);
        if ($user && hash_equals($user['password'], crypt($password, $user['password']))) {
            $_SESSION['username'] = $username;
            logActivity($username, 'Login', 'User logged in successfully');
            header("Location: welcome.php");
            exit();
        } else {
            logActivity($username, 'Login', 'User login failed');
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }
} else {
    echo "Error fetching user data.";
}

pg_close($conn);
?>
