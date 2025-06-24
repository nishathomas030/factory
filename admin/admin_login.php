<?php
session_start();
include '../db.php'; // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_password);
    $stmt->fetch();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        // Verify the password (no hashing)
        if ($password === $db_password) {
            // Store username in session
            $_SESSION['username'] = $username;
            echo "<script>alert('Login successful!'); window.location.href = 'content.html';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../login.css" />
</head>

<body>
    <div class="login-card">
        <h2><img src="../log.png" alt="Logo"></h2>
        <h3>Enter your credentials</h3>
        <form class="login-form" method="post">
            <input type="text" placeholder="Username" id="username" name="username" required>
            <input type="password" placeholder="Password" id="password" name="password" required>
            <input class="Login" type="submit" value="Sign In">
            <!-- <a href="index.html">Go Back</a> -->
        </form>
    </div>

    <script>
        // Optional: Client-side validation
        document.querySelector(".login-form").addEventListener("submit", function (event) {
            let username = document.getElementById('username').value;
            let password = document.getElementById('password').value;

            if (username === "" || username === null) {
                alert("Enter your username");
                event.preventDefault(); // Prevent form submission
            }

            if (password.length <= 5) {
                alert("Valid password required.");
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>

</html>