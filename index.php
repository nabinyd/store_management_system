<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Store Management</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
</head>

<body>
    <div class="header">
        <h1 id="head1">Welcome to Store Management</h1>
    </div>
    <div class="navbar">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="user/index.php">Home</a>';
            echo '<a href="user/view_products.php">View Products</a>';
            echo '<a href="user/place_order.php">Place Order</a>';
            echo '<a href="user/logout.php">Logout</a>';
            echo '<a href="admin/login.php">Login as admin</a>';
        } elseif (isset($_SESSION['admin_id'])) {
            echo '<a href="admin/dashboard.php">Dashboard</a>';
            echo '<a href="admin/manage_products.php">Manage Products</a>';
            echo '<a href="admin/manage_customers.php">Manage Customers</a>';
            echo '<a href="admin/manage_orders.php">Manage Orders</a>';
            echo '<a href="admin/logout.php">Logout</a>';
            echo '<a href="user/login.php">Login as user</a>';
        }  elseif( isset($_SESSION[''])){
            echo '<a href="user/index.php">Home</a>';
            echo '<a href="user/view_products.php">View Products</a>';
            echo '<a href="user/place_order.php">Place Order</a>';
            echo '<a href="user/logout.php">Logout</a>';
            echo '<a href="admin/login.php">Login as admin</a>';
            echo '<a href="user/login.php">Login as user</a>';
        }
        else {
            echo '<a href="user/register.php">Register</a>';
            echo '<a href="user/login.php">Login</a>';
            echo '<a href="admin/login.php">Admin Login</a>';
            // echo '<a href="admin/register.php">Admin Register</a>';

        }
        ?>
    </div>
    <div class="container">
        <!-- <h2>Welcome to our Store Management System</h2> -->
        <p>This is a simple store management system where users can view products and place orders, and admins can manage products, customers, and orders.</p>
        <h3>Project Created By:</h3>
        <ul>
            <li>Sushant Niraula</li>
            <li>Nabin Yadav</li>
            <li>Lokesh Kumar Mandal</li>
            <li>Sneha Yadav</li>
        </ul>
    </div>
</body>
</html>
