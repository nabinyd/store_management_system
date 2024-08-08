<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock_quantity = $_POST['stock_quantity'];

        $sql = "INSERT INTO products (name, description, price, stock_quantity) VALUES ('$name', '$description', '$price', '$stock_quantity')";

        if ($conn->query($sql) === TRUE) {
            echo "Product added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    // Handle other actions like edit and delete here
}


// delete product action 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {

        $product_id = $conn->real_escape_string($_POST['product_id']);

        $sql = "DELETE FROM orders WHERE product_id='$product_id'";
        $conn->query($sql);

        $sql = "DELETE FROM products WHERE product_id='$product_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Product deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>
<body>
    <div class="header">
        <h1>Manage Products</h1>
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
        <h2>Add New Product</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" id="stock_quantity" name="stock_quantity" required>
            </div>
            <button type="submit" name="add_product" class="button">Add Product</button>
        </form>

        <h2>Existing Products</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock Quantity</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["product_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["description"] . "</td><td>" . $row["price"] . "</td><td>" . $row["stock_quantity"] . "</td><td>
                <a href='edit_product.php?product_id=" . $row["product_id"] . "'>Edit</a>
                <form method='post' action=''>
                    <input type='hidden' name='product_id' value='" . $row["product_id"] . "'>
                    <button type='submit' name='delete_product' class='button'>Delete</button>
                </form>
                </td></tr>";
            }
            echo "</table>";
        } else {
            echo "No products found";
        }
        ?>
    </div>
</body>
</html>
