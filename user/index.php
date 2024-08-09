<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// get the users orders from the orders table
include '../db.php';

$user_id = $_SESSION['user_id'];



$sql = "SELECT o.order_id, p.name as product_name, o.quantity, o.order_date
        FROM orders o 
        JOIN products p ON o.product_id = p.product_id
        WHERE o.customer_id=$user_id";
$result = $conn->query($sql);



if ($_SERVER["REQUEST_METHOD"] == "POST" )  {


    if (isset($_POST['delete_order'])) {

        $order_id = $conn->real_escape_string($_POST['order_id']);
    
        $sql_delete = "DELETE FROM orders WHERE order_id='$order_id'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Order deleted successfully";
            $result = $conn->query($sql);
        } else {
            echo "Error1: " . $sql_delete . "<br>" . $conn->error;
        }
    } else {
        echo "Error2: " . $sql_delete . "<br>" . $conn->error;
    }
} 


?>

<!DOCTYPE html>
<html>
<head>
    <title>Store Home</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>
<body>
    <div class="header">
        <h1>Welcome to Our Store</h1>
    </div>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="view_products.php">View Products</a>
        <a href="place_order.php">Place Order</a>
        <a href="logout.php">Logout</a>
        <a href="../admin/login.php">Login as admin</a>
    </div>
    <div class="container ">
        <h2>Welcome, <?php echo $_SESSION['user_name']; ?></h2>
        <!-- Add additional content or features here -->
        <h3>Your orders</h3>

        <?php
        if ($result->num_rows > 0) {
            echo "<table><tr><th>Order ID</th><th>Product</th><th>Quantity</th><th>Order Date</th>
             <th>Actions</th>
            </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["order_id"] . "</td><td>" . $row["product_name"] . "</td>
                <td>" . $row["quantity"] . "</td>
                <td>" . $row["order_date"] . "</td>
                <td>
                <form method='post' action=''>
                <input type='hidden' name='order_id' value='" . $row["order_id"] . "'>
                <button type='submit' name='delete_order' class='button'>Delete</button>
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
