<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "factory_mng";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Get user details from DB
    $stmt = $conn->prepare("SELECT userid, email, password FROM user_table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userid, $db_email, $db_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Verify hashed password
        if (password_verify($password, $db_password)) {
            $_SESSION['userid'] = $userid;
            $_SESSION['email'] = $db_email;

            // Redirect to home page using JavaScript to avoid header issues
            echo "<script>
                alert('Login successful!);
                window.location.href = 'home.php';
            </script>";
            exit();
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
