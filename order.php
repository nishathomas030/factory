<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo "<p style='color:red;'>Access denied. Please <a href='login.php'>login</a> first.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = ""; // your MySQL password
    $dbname = "factory_mng";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $name = htmlspecialchars(trim($_POST["name"]));
    $address = htmlspecialchars(trim($_POST["address"]));
    $milkQuantity = isset($_POST["milkQuantity"]) ? intval($_POST["milkQuantity"]) : 0;
    $drumQuantity = isset($_POST["drumQuantity"]) ? intval($_POST["drumQuantity"]) : 0;
    $products = isset($_POST["product"]) ? $_POST["product"] : [];
    $userId = $_SESSION['userid'];

    $errors = [];

    if (empty($name)) $errors[] = "Name is required.";
    if (empty($address)) $errors[] = "Address is required.";
    if (empty($products)) $errors[] = "At least one product must be selected.";
    if (in_array("Milk", $products) && $milkQuantity == 0) $errors[] = "Milk quantity must be more than 0.";
    if (in_array("Drum", $products) && $drumQuantity == 0) $errors[] = "Drum quantity must be more than 0.";

    if (count($errors) > 0) {
        echo "<div class='form-container'>";
        foreach ($errors as $error) echo "<p class='error'>$error</p>";
        echo "<a href='order.php' style='color: blue;'>Go Back</a></div>";
        exit;
    }

    // Insert including user_id
    $stmt = $conn->prepare("INSERT INTO orders (name, address, product_milk_quantity, product_drum_quantity, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $name, $address, $milkQuantity, $drumQuantity, $userId);

    if ($stmt->execute()) {
        echo "<div class='form-container'><h3>Order Submitted Successfully!</h3>";
        echo "<p>Thank you, $name. Your order has been recorded.</p><ul>";
        if ($milkQuantity > 0) echo "<li>Milk Quantity: $milkQuantity</li>";
        if ($drumQuantity > 0) echo "<li>Drum Quantity: $drumQuantity</li>";
        echo "</ul><a href='order.php'>Back to Form</a></div>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(90deg, rgba(0,36,1,1) 0%, rgba(9,121,80,1) 35%, rgba(0,255,162,1) 100%);
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        input[type="text"], input[type="number"], textarea, button {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #ddd;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            width: 105%;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            font-size: 0.8em;
        }
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        #logout {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 12px;
            font-size: 14px;
            background-color: red;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            width: 80px;
        }
        #goback {
            position: fixed;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            width: 50px;
        }
        #save{
            margin-left:130px;
            width:150px;
        }
    </style>
</head>
<body>
    <button onclick="location.href='index.html'"id="logout">LOGOUT</button>
    <a href="content1.html"><button id="goback"><</button></a>


<div class="form-container">

    <h2><center>Order Form</center></h2>
    <form method="POST" action="">
        <label>Name:</label>
        <input type="text" id="fullname" placeholder="Fullname"  name="name"onkeypress="return /^[A-Za-z\s]+$/.test(event.key)" required>
        <label>Address:</label>
        <textarea name="address" required></textarea>
        
        <label>Contact Number:</label>
        <input type="text" id="phno" maxlength="10" placeholder="Contact number" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"required>
        <div class="checkbox-group">
            <label>
                <input type="checkbox" name="product[]" value="Milk"> Barrels
            </label>
            <input type="number" name="milkQuantity" value="" min="0" placeholder="Number of Barrel">

            <label>
                <input type="checkbox" name="product[]" value="Drum"> Latex
            </label>
            <input type="number" name="drumQuantity" value="" min="0" placeholder="Latex Quantity">
        </div>

        <button type="submit" id="save">Place Order</button>
    </form>
</div>

</body>
</html>
