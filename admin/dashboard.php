<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="manage_customers.php">Manage Customers</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Welcome, Admin</h2>
                <!-- Add additional content or features here -->
                 <!-- Add additional content or features here -->
<div class="dashboard">
    <div class="card">
        <h2>Register Admin</h2>
        <p>Register a new admin</p>
        <a href="admin_register.php">Go to Admin Registration</a>
    </div>
    <div class="card">
        <h2>Products</h2>
        <p>Manage your products</p>
        <a href="manage_products.php">Go to Products</a>
    </div>
    <div class="card">
        <h2>Customers</h2>
        <p>Manage your customers</p>
        <a href="manage_customers.php">Go to Customers</a>
    </div>
    <div class="card">
        <h2>Orders</h2>
        <p>Manage your orders</p>
        <a href="manage_orders.php">Go to Orders</a>
    </div>
</div>
</body>
</html>
