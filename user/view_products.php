<?php
include '../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM products";


$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $products[] = $row;
    }
} else {
    echo "No products found";
}

if (isset($_GET['search_query'])) {
    $search_query = $_GET['search_query'];
    $search_query = "%" . $search_query . "%"; // Prepare the search string for a LIKE query

    // SQL query to search for products by product_id or name
    $sql = "SELECT * FROM products 
            WHERE product_id LIKE ?
            OR name LIKE ? 
            OR description LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $search_query, $search_query, $search_query);
    $stmt->execute();
    $search_result = $stmt->get_result();

    if ($search_result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock Quantity</th></tr>";
        while ($row = $search_result->fetch_assoc()) {
            echo "<tr><td>" . $row["product_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["description"] . "</td><td>" . $row["price"] . "</td><td>" . $row["stock_quantity"] . "</td><td>
            </td></tr>";
        }
        echo "</table>";
    } else {
        echo "No products found.";
    }

    $stmt->close();
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
        <a href="../admin/login.php">Login as admin</a>
    </div>
    <div class="search_product">
        <form method="GET" action="">
            <input type="text" name="search_query" placeholder="Search products..." style="width:300px">
            <button type="submit">Search</button>
        </form>
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