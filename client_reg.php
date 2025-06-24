<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registration</title>
    <link href="Register.css" rel="stylesheet">
    <script>
        function checkPasswordLength() {
            let password = document.getElementById("password").value;
            let warning = document.getElementById("passWarning");

            if (password.length > 0 && password.length < 6) {
                warning.style.display = "block";
            } else {
                warning.style.display = "none";
            }
        }
        function validateForm()
        {
        let fullname = document.getElementById("fullname").value.trim();
        let email = document.getElementById("email").value.trim();
        let address = document.getElementById("address").value.trim();
        let phno = document.getElementById("phno").value.trim();
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("confirm_password").value;

        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let phonePattern = /^[0-9]{10}$/;
        let namePattern = /^[A-Za-z]+(?: [A-Za-z]+)*$/;


        if (fullname === "") {
        alert("Full name is required!");
        return false;
        }
        if (!namePattern.test(fullname) || /\d/.test(fullname)) {
        alert("Name should only contain letters and spaces, no numbers!");
        return false;
        }

        if (!emailPattern.test(email)) {
        alert("Enter a valid email address!");
        return false;
        }
        if (address === "") {
        alert("Address is required!");
        return false;
        }
        if (!phonePattern.test(phno)) {
        alert("Enter a valid 10-digit phone number!");
        return false;
        }
        if (password.length < 6 || password.length > 12) {
        alert("Password must be between 6 to 12 characters long!");
        return false;
        }
        if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
        }
        return true;
        }
    </script>
</head>

<body>
    <?php
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $phno = trim($_POST['phno']);
        $password = $_POST['password'];

        // Prepared statement for user registration
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR phno=?");
        $stmt->bind_param("ss", $email, $phno);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('User  with this email or phone number already exists!');</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, address, phno, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $email, $address, $phno, $password);
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href = 'client_login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
        $conn->close();
    }
    ?>
    <center>
        <form method="POST" action="" onsubmit="return validateForm()">
            <h1>Create your Account</h1>
            <img src="icon.png" style="width:100px; height: 100px;"><br><br>
            <table>
                <tr>
                    <td class="txt">Full Name</td>
                    <td><input type="text" name="fullname" id="fullname" placeholder="Fullname" onkeypress="return /^[A-Za-z\s]+$/.test(event.key)" required>
                    <br></td>
                </tr>
                <tr>
                    <td class="txt">Email</td>
                    <td><input type="email" placeholder="Email" id="email" name="email" required><br></td>
                </tr>
                <tr>
                    <td class="txt">Address</td>
                    <td><input type="text" placeholder="Address" id="address" name="address" required><br></td>
                </tr>
                <tr>
                    <td class="txt">Phone Number</td>
                    <td><input type="text" name="phno" id="phno" maxlength="10" placeholder="Contact number" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                    required><br></td>
                </tr>
                <tr>
                    <td class="txt">Password</td>
                    <td><input type="password" placeholder="Password" id="password" name="password" required><br></td>
                </tr>
                <tr>
                    <td class="txt">Confirm Password</td>
                    <td><input type="password" placeholder="Confirm Password" id="confirm_password" required><br></td>
                </tr>
            </table>
            <br>
            <button type="submit">Register</button>
            <p>Already have an account? <a href="client_login.php">Login here</a></p>
        </form>
    </center>
</body>

</html>