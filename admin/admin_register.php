<?php
include '../db.php';
session_start();

// Check if the current user is an admin
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: login.php");
//     exit();
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the username already exists
    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "Username already exists";
    } else {
        $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Admin registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <div class="header">
        <h1>Admin Registration</h1>
    </div>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="admin_register.php">Register Admin</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="manage_customers.php">Manage Customers</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="logout.php">Logout</a>
        <a href=" ../user/login.php"> login as user</a>
    </div>
    <div class="container">
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="button">Register</button>
        </form>
        <p>already have an account: <a href="login.php">Log in</a></p>
    </div>
</body>
</html>
