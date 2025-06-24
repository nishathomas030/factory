<?php
include '../db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location.href='milk_view.php';</script>";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "DELETE FROM milk_collection WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Record deleted successfully!'); window.location.href='milk_view.php';</script>";
} else {
    echo "<script>alert('Error deleting record: " . mysqli_error($conn) . "'); window.location.href='milk_view.php';</script>";
}

mysqli_close($conn);
?>