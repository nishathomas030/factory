<?php
include '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM drum_export WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Record deleted successfully!'); window.location.href='edrum_view.php';</script>";
    } else {
        echo "<script>alert('Error deleting record'); window.location.href='edrum_view.php';</script>";
    }
}

mysqli_close($conn);
?>