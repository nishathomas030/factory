<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $barrels = $_POST['barrels'];

    $query = "INSERT INTO drum_export (date, barrels) VALUES ('$date', '$barrels')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Record added successfully!'); window.location.href='edrum_view.php';</script>";
    } else {
        echo "<script>alert('Error adding record');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Drum Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 450px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            width: 500px;
        }

        .save-btn {
            background-color: green;
            color: white;
            margin-left:160px;
            width: 150px;
        }

        .save-btn:hover {
            background-color: darkgreen;
        }

        .cancel-btn {
            background-color: red;
            color: white;
        }

        .cancel-btn:hover {
            background-color: darkred;
        }
        .form-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.form-group label {
    font-weight: bold;
    flex: 1;
    text-align: right;
    margin-right: 15px;
}

.form-group input {
    flex: 2;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
#goback {
    position: fixed; /* stays fixed even if page scrolls */
    left: 10px; /* distance from left */
    top: 50%; /* center vertically */
    transform: translateY(-50%);
    background-color: blue;
    color: white;
    padding: 10px 15px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width:50px
}
#logout {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 8px 12px;
    font-size: 14px;
    background-color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: red;
    width:80px;
}
    </style>
</head>

<body>
<button onclick="location.href='../index.html'"id="logout">LOGOUT</button>

<a href="eDrum(add&view).html"><button id="goback"><</button></a>

<div class="form-container">
        <h2>Barrel Dispatch</h2>
        <form method="POST" action="">
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            
        </div>
        <div class="form-group">
            <label for="date">No of Barrels:</label>
            <input type="number" id="barrels" name="barrels" required>
            
        </div>
            <div class="btn-container">
                <button type="submit" class="save-btn">Save</button>
                
        </form>
    <script>
        window.onload = function () {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById("date").setAttribute("max", today);
        };
    </script>
</body>

</html>