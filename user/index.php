<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// get the users orders from the orders table
include '../db.php';

$user_id = $_SESSION['user_id'];



$sql = "SELECT o.order_id, p.name as product_name, o.quantity
        FROM orders o 
        JOIN products p ON o.product_id = p.product_id
        WHERE o.customer_id=$user_id";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Store Home</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>
<body>
    <div class="header">
        <h1>Welcome to Our Store</h1>
    </div>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="view_products.php">View Products</a>
        <a href="place_order.php">Place Order</a>
        <a href="logout.php">Logout</a>
        <a href="../admin/login.php">Login as admin</a>
    </div>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>
        <!-- Add additional content or features here -->
        <h5>Your orders</h5>

        <?php
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Order ID</th><th>Product</th><th>Quantity</th><th>Order Date</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["order_id"] . "</td><td>" . $row["product_name"] . "</td><td>" . $row["quantity"] . "</td></td></tr>";
            }
            echo "</table>";
        } else {
            echo "No orders found";
        }
        ?>

    </div>
</body>
</html>
