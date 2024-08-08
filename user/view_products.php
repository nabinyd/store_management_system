<?php
include '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM products";

$result = $conn->query($sql);

// get the order quantity for each product from orders table and then set the stock quantity to stock quantity - order quantity

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $order_sql = "SELECT SUM(quantity) as quantity FROM orders WHERE product_id=$product_id";
        $order_result = $conn->query($order_sql);
        $order_row = $order_result->fetch_assoc();
        $total_ordered = $order_row['quantity']? $order_row['quantity'] : 0;

        $row['stock_quantity'] = $row['stock_quantity'] - $total_ordered;

        $products[] = $row;
    }
} else {
    echo "No products found";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
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
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock Quantity</th>
            </tr>
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    echo "<tr>";
                    echo "<td>" . $product["product_id"] . "</td>";
                    echo "<td>" . $product["name"] . "</td>";
                    echo "<td>" . $product["description"] . "</td>";
                    echo "<td>" . $product["price"] . "</td>";
                    echo "<td>" . ($product["stock_quantity"] <= 0 ? "Out of Stock" : $product["stock_quantity"]) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
        
    </div>
</body>
</html>
