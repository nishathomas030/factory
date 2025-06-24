<?php
include '../db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid record!'); window.location.href='milk_view.php';</script>";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM milk_collection WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Record not found!'); window.location.href='milk_view.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $latex = mysqli_real_escape_string($conn, $_POST['latex']);

    $updateQuery = "UPDATE milk_collection SET date='$date', latex='$latex' WHERE id='$id'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Record updated successfully!'); window.location.href='milk_view.php';</script>";
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
    <title>Edit Latex Record</title>
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
            font-size: 16px;
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
            background-color: #28a745;
            color: white;
        }

        .update-btn:hover {
            background-color: #218838;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <div class="edit-container">
        <h2>Edit Latex Record</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

            <label for="date">Date:</label>
            <input type="date" name="date" value="<?php echo htmlspecialchars($row['date']); ?>" required>

            <label for="latex">Latex:</label>
            <input type="text" name="latex" value="<?php echo htmlspecialchars($row['latex']); ?>" required>

            <div class="btn-container">
                <button type="submit" class="update-btn">Update</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='milk_view.php'">Cancel</button>
            </div>
        </form>
    </div>

</body>

</html>