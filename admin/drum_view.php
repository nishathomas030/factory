<?php
include '../db.php'; // Include database connection

$query = "SELECT id, date, barrels FROM drum_collection"; // Fetch required fields
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Drum Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: #f4f4f4;
        }

        table {
            width: 60%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 8px 12px;
            margin: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
        }

        .add-btn {
            background-color: green;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
        }

        .add-btn:hover {
            background-color: darkgreen;
        }

        .edit-btn {
            background-color: blue;
            color: white;
        }

        .edit-btn:hover {
            background-color: darkblue;
        }

        .delete-btn {
            background-color: red;
            color: white;
        }

        .delete-btn:hover {
            background-color: darkred;
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
    
<a href="Drum(add&view).html"><button id="goback"><</button></a>
<button onclick="location.href='../index.html'"id="logout">LOGOUT</button>
    <h2>Barrel Records</h2>

    <button class="add-btn" onclick="window.location.href='drum_add.php'">Add New Record</button>

    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Barrels</th>
            <th>Actions</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['barrels']}</td>
                        <td>
                            <button class='edit-btn' onclick=\"window.location.href='drum_edit.php?id={$row['id']}'\">Edit</button>
                            <button class='delete-btn' onclick=\"confirmDelete({$row['id']})\">Delete</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </table>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "drum_delete.php?id=" + id;
            }
        }
    </script>
</body>

</html>