<?php
// Start the session and include session authentication check
session_start();

// Check if the user is logged in, if not redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: ../authentication/login.php");
    exit();
}

// Include the database connection file
include_once __DIR__ . '/connection.php'; // Use absolute path for reliability

// Check if $pdo is defined
if (!isset($pdo)) {
    die("Database connection not established.");
}

// Set the number of products to display per page
$products_per_page = 5;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $products_per_page;

// Fetch total products to calculate total pages
$total_query = "SELECT COUNT(*) FROM products";
$total_stmt = $pdo->query($total_query);
$total_products = $total_stmt->fetchColumn();
$total_pages = ceil($total_products / $products_per_page);

// Fetch products for the current page
$query = "SELECT * FROM products LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':limit', $products_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<html>
    <head>
        <title>Product List</title>
        <link rel="stylesheet" href="../public/styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    </head>
    <body>
        <div class="product-container">
            <h1>Product List</h1>

            <p><a href="addproduct.php">Add New Product</a></p> <!-- Link to Add Product -->

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock Level</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($product['stock_level']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="pagination">
                <?php if ($current_page > 1): ?>
                    <a href="?page=<?php echo $current_page - 1; ?>">« Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" <?php if ($i === $current_page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="?page=<?php echo $current_page + 1; ?>">Next »</a>
                <?php endif; ?>
            </div>

            <!-- Back to Welcome Page -->
            <div class="back-button">
                <a href="../authentication/welcome.php" class="back-link">Back to Welcome Page</a>
            </div>
            <div class="chat-icon" style="position: fixed; bottom: 20px; right: 20px;">
                <a href="../Chatbot/index.php" style="text-decoration: none;">
                    <div style="background-color: #007bff; color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: background-color 0.3s;">
                        <i class="fas fa-comments" style="font-size: 24px;"></i>
            </div>
        </div>
    </body>
</html>
