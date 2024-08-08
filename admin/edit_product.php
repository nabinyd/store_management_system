<!-- #region -->

<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_product'])) {
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock_quantity = $_POST['stock_quantity'];

        $sql = "UPDATE products SET name= ?, description= ?, price= ?, stock_quantity= ? WHERE product_id= ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdii", $name, $description, $price, $stock_quantity, $product_id);

        if ($stmt->execute() === TRUE) {
            echo "Product updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $sql = "SELECT * FROM products WHERE product_id='$product_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $stock_quantity = $row['stock_quantity'];
    } else {
        echo "Product not found";
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
        <h1>Update Products</h1>
    </div>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="manage_customers.php">Manage Customers</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="logout.php">Logout</a>
        <a href="../user/login.php"> login as user</a>
    </div>
    <div class="container">
        <form method="post" action="">
            <div class="form-group">
                <label for="product_id">Product:</label>
                <select id="product_id" name="product_id" required>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["product_id"] . "'>" . $row["name"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" value="<?php echo $description; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo $price; ?>" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" id="stock_quantity" name="stock_quantity" value="<?php echo $stock_quantity; ?>" required>
            </div>
            <button type="submit" name="edit_product" class="button">Edit Product</button>
        </form>
    </div>
</body>
</html>