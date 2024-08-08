<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Store Management</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="header">
        <h1>Welcome to Store Management</h1>
    </div>
    <div class="navbar">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="user/index.php">Home</a>';
            echo '<a href="user/view_products.php">View Products</a>';
            echo '<a href="user/place_order.php">Place Order</a>';
            echo '<a href="user/logout.php">Logout</a>';
        } elseif (isset($_SESSION['admin_id'])) {
            echo '<a href="admin/dashboard.php">Dashboard</a>';
            echo '<a href="admin/manage_products.php">Manage Products</a>';
            echo '<a href="admin/manage_customers.php">Manage Customers</a>';
            echo '<a href="admin/manage_orders.php">Manage Orders</a>';
            echo '<a href="admin/logout.php">Logout</a>';
        } else {
            echo '<a href="user/register.php">Register</a>';
            echo '<a href="user/login.php">Login</a>';
            echo '<a href="admin/login.php">Admin Login</a>';

        }
        ?>
    </div>
    <div class="container">
        <h2>Welcome to our Store Management System</h2>
        <p>This is a simple store management system where users can view products and place orders, and admins can manage products, customers, and orders.</p>
    </div>
</body>
</html>
