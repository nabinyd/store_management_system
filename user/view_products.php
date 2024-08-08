<?php
include '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <div class="header">
        <h1>Products</h1>
    </div>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="view_products.php">View Products</a>
        <a href="place_order.php">Place Order</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock Quantity</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["product_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["description"] . "</td><td>" . $row["price"] . "</td><td>" . $row["stock_quantity"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No products found";
        }
        ?>
    </div>
</body>
</html>
