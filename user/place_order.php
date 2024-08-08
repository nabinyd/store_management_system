<?php
include '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO orders (customer_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully";
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
    <title>Place Order</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <div class="header">
        <h1>Place Order</h1>
    </div>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="view_products.php">View Products</a>
        <a href="place_order.php">Place Order</a>
        <a href="logout.php">Logout</a>
        <a href="../admin/login.php">Login as admin</a>
    </div>
    <div class="container">
        <form method="post" action="">
            <div class="form-group">
                <label for="product_id">Product:</label>
                <select id="product_id" name="product_id" required>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["product_id"] . "'>" . $row["name"] . " - $" . $row["price"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="button">Place Order</button>
        </form>
    </div>
</body>
</html>
