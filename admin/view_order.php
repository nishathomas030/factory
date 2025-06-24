<?php
session_start();

// Optional: Only allow access if admin is logged in
// if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
//     echo "Access denied.";
//     exit;
// }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "factory_mng";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT orders.*, users.fullname, users.email, users.phno 
        FROM orders 
        LEFT JOIN users ON orders.user_id = users.id 
        ORDER BY orders.order_time DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(90deg, rgba(0,36,1,1) 0%, rgba(9,121,80,1) 35%, rgba(0,255,162,1) 100%);
            color: #333;
            padding: 40px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #00000022;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h2 {
            margin-top: 0;
        }
        #goback {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        #goback:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <a id="goback" href="content.html">← Back</a>
    <h2>All Orders</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Barrels </th>
                <th>Latex</th>
                <th>Order Time</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["name"]) ?></td>
                <td><?= htmlspecialchars($row["address"]) ?></td>
                <td><?= $row["product_milk_quantity"] ?></td>
                <td><?= $row["product_drum_quantity"] ?></td>
                <td><?= $row["order_time"] ?></td>
                <td><?= htmlspecialchars($row["fullname"]) ?></td>
                <td><?= htmlspecialchars($row["email"]) ?></td>
                <td><?= htmlspecialchars($row["phno"]) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
