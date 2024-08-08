<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT o.order_id, c.name as customer_name, p.name as product_name, o.quantity 
        FROM orders o 
        JOIN customers c ON o.customer_id = c.customer_id 
        JOIN products p ON o.product_id = p.product_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <div class="header">
        <h1>Manage Orders</h1>
    </div>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="manage_customers.php">Manage Customers</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="logout.php">Logout</a>
        <a href=" ../user/login.php"> login as user</a>
    </div>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Order ID</th><th>Customer</th><th>Product</th><th>Quantity</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["order_id"] . "</td><td>" . $row["customer_name"] . "</td><td>" . $row["product_name"] . "</td><td>" . $row["quantity"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No orders found";
        }
        ?>
    </div>
</body>
</html>
