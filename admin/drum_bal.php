<?php
include '../db.php'; // make sure this file connects $conn properly

$sql = "
SELECT 
  COALESCE((SELECT SUM(barrels) FROM drum_collection), 0) 
  - 
  COALESCE((SELECT SUM(barrels) FROM drum_export), 0) 
  AS balance_drums
";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$balance = $row['balance_drums'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Drum Balance</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eef2f3;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow:hidden;
    }
    .card {
      background: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      text-align: center;
    }
    .card h2 {
      margin-bottom: 15px;
    }
    .value {
      font-size: 50px;
      color: #004d99;
      font-weight: bold;
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
<a href="content.html" id="goback"><</a>
  <button onclick="location.href='../index.html'"id="logout">LOGOUT</button>

  <div class="card">
    <h2>Available Barrel Balance</h2>
    <div class="value"><?php echo $balance; ?> Drums</div>
  </div>
</body>
</html>
