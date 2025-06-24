<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "factory_mng";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error)
{
    echo "Failed to connect DB".$conn->connect_error;
}
?>