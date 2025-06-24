<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM drum_collection WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $barrels = $_POST['barrels'];

    $updateQuery = "UPDATE drum_collection SET date='$date', barrels='$barrels' WHERE id=$id";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Record updated successfully!'); window.location.href='drum_view.php';</script>";
    } else {
        echo "<script>alert('Error updating record');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Drum Record</title>
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

        .edit-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
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
            width: 48%;
        }

        .update-btn {
            background-color: blue;
            color: white;
        }

        .update-btn:hover {
            background-color: darkblue;
        }

        .cancel-btn {
            background-color: red;
            color: white;
        }

        .cancel-btn:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>

    <div class="edit-container">
        <h2>Edit Drum Record</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label for="date">Date:</label>
            <input type="date" name="date" value="<?php echo $row['date']; ?>" required>

            <label for="barrels">Barrels:</label>
            <input type="number" name="barrels" value="<?php echo $row['barrels']; ?>" required>

            <div class="btn-container">
                <button type="submit" class="update-btn">Update</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='drum_view.php'">Cancel</button>
            </div>
        </form>
    </div>

</body>

</html>