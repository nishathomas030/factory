<?php
// Connect to MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "factory_mng";  // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the data from both tables
$sql = "SELECT 
            m.id, 
            m.date, 
            m.quantity AS import_quantity, 
            e.quantity AS export_drums, 
            e.quantity * 197 AS exported_quantity,
            (m.quantity - (e.quantity * 197)) AS quantity_difference
        FROM milk_collection m
        LEFT JOIN drum_export e
        ON m.id = e.id AND m.date = e.date";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Collection vs Drum Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .message {
            font-size: 18px;
            color: green;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Milk Collection vs Drum Export</h1>
</header>

<div class="container">
    <h2>Milk Collection and Drum Export Comparison</h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Import Quantity (kg)</th>
                    <th>Export Drums</th>
                    <th>Exported Quantity (kg)</th>
                    <th>Quantity Difference (kg)</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["date"] . "</td>
                    <td>" . $row["import_quantity"] . "</td>
                    <td>" . $row["export_drums"] . "</td>
                    <td>" . $row["exported_quantity"] . "</td>
                    <td>" . $row["quantity_difference"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='message'>No data found</div>";
    }

    // Close the connection
    $conn->close();
    ?>
</div>

</body>
</html>
