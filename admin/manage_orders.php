<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT o.order_id, c.name as customer_name, p.name as product_name, o.quantity , o.order_date
        FROM orders o 
        JOIN customers c ON o.customer_id = c.customer_id 
        JOIN products p ON o.product_id = p.product_id";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order'])) {
    $order_id = $conn->real_escape_string($_POST['order_id']);

    $sql = "DELETE FROM orders WHERE order_id='$order_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Order deleted successfully";
    }
}


if (isset($_GET['search_query'])) {
    $search_query = $_GET['search_query'];
    $search_query = "%" . $search_query . "%"; // Prepare for LIKE query

    // SQL query to search in the view
    $sql = "SELECT * FROM customer_product_view 
            WHERE customer_id LIKE ? 
            OR `name` LIKE ? 
            OR product_name LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $search_query, $search_query, $search_query);
    $stmt->execute();
    $search_result = $stmt->get_result();

    if ($search_result->num_rows > 0) {
        echo "<table><tr><th>Customer ID</th><th>Customer Name</th><th>Product Name</th></tr>";
        while ($row = $search_result->fetch_assoc()) {
            echo "<tr><td>" . $row["customer_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["product_name"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No records found.";
    }

    $stmt->close();
} else {
    echo "Please enter a search query.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
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
    <div>
        <form method="GET" action="">
            <input type="text" name="search_query" placeholder="Search by Customer Name, ID, or Product Name..." style="width:250px">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="container manage_orders">
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
            <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Actions</th>
        </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["order_id"] . "</td><td>" . $row["customer_name"] . "</td><td>" . $row["product_name"] . "</td><td>" . $row["quantity"] . "</td>
                <td>" . $row["order_date"] . "</td>
                <form method='post' action=''>
                <input type='hidden' name='order_id' value='" . $row["order_id"] . "'>
                <td> <button type='submit' name='delete_order' class='button'>Delete</button></td>
                </form>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "No orders found";
        }
        ?>
    </div>
</body>

</html>