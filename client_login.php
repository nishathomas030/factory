<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userid, $db_password);
    $stmt->fetch();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        // Verify the password
        if ($password === $db_password) { // Assuming passwords are stored in plain text
            $_SESSION['userid'] = $userid;
            $_SESSION['email'] = $email; // Store email in session
            echo "<script>alert('Login successful!'); window.location.href = 'content1.html';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password.');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="login.js"></script>
    <link rel="stylesheet" href="login.css" />
</head>

<body>
    <div class="login-card">
        <h2><img src="log.png" alt="Logo"></h2>
        <h3>Enter your credentials</h3>
        <form class="login-form" action="" method="post" onsubmit="return validate()">
            <input type="text" placeholder="Email" id="email" name="email" required>
            <input type="password" placeholder="Password" id="password" name="password" required>
            <!-- <a href="client_reg.php">Register Here</a> -->
            <input class="Login" type="submit" value="Sign In">
            <a href="index.html">Go Back</a>
        </form>
    </div>

    <script>
        function validate() {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;

            if (email === "" || email === null) {
                alert("Enter your email");
                return false;
            }

            if (password.length <= 5) {
                alert("Valid password required.");
                return false;
            }
            return true; // Allow form submission
        }
    </script>
</body>

</html>