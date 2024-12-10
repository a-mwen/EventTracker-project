<?php

$host = 'localhost';
$db = 'project-WAD';
$user = 'postgres';
$pass = '317!!Musha4lyf';
$port = '5437'; 

try {
    // Create a new PDO connection to PostgreSQL
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection error: " . $e->getMessage();
    exit;
}

// Logic
if (isset($_POST['user_input'])) {
    $user_input = $_POST['user_input'];
    $stmt = $pdo->prepare("SELECT answer FROM faq WHERE question ILIKE :question");
    $stmt->execute([':question' => '%' . $user_input . '%']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['answer' => $result['answer']]);
    } else {
        echo json_encode(['answer' => "I'm sorry, I don't have an answer to that question. Please ask another question."]);
    }
}
?>