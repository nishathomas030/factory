<?php
include '../db.php'; // Include database connection

$query = "SELECT id, date, latex FROM milk_collection"; // Fetch required fields
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Milk Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: #f9f9f9;
        }

        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .add-btn {
            background-color: green;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .add-btn:hover {
            background-color: darkgreen;
        }

        .edit-btn {
            background-color: blue;
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .edit-btn:hover {
            background-color: darkblue;
        }

        .delete-btn {
            background-color: red;
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .delete-btn:hover {
            background-color: darkred;
        }

        .no-records {
            text-align: center;
            font-size: 18px;
            color: #888;
            padding: 20px;
            font-weight: bold;
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
    
<a href="Milk(add&view).html"><button id="goback"><</button></a>

    <h2>Latex Records</h2>

    <button class="add-btn" onclick="window.location.href='milk_add.php'">Add New Record</button>

    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Latex</th>
            <th>Actions</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['latex']}</td>
                        <td>
                            <button class='edit-btn' onclick=\"window.location.href='milk_edit.php?id={$row['id']}'\">Edit</button>
                            <button class='delete-btn' onclick=\"confirmDelete({$row['id']})\">Delete</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='no-records'>No Records Found</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </table>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "milk_delete.php?id=" + id;
            }
        }
    </script>
</body>

</html>