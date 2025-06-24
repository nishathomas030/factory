<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Milk Collection</title>
    <style>
        body {
    background-color: #f2f2f2;
    font-family: Arial, sans-serif;
}

.form-container {
    background-color: white;
    width: 500px;
    margin: 80px auto;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.form-container h2 {
    margin-bottom: 30px;
    font-size: 26px;
}

.form-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.form-group label {
    font-weight: bold;
    flex: 1;
    text-align: right;
    margin-right: 15px;
}

.form-group input {
    flex: 2;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #05650b;
    color: white;
    padding: 10px 50px; /* Increased horizontal padding */
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
    width: 150px; /* Optional: set a fixed width */
}

button:hover {
    background-color: #044d08;
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
    <script>
        function validateForm() {
            let date = document.getElementById("date").value;
            let latex = document.getElementById("latex").value;

            if (date === "") {
                alert("Date is required!");
                return false;
            }
            if (latex === "" || isNaN(latex) || latex <= 0) {
                alert("Enter a valid latex quantity!");
                return false;
            }
            return true;
            
    }
        
    </script>
</head>

<body>
<button onclick="location.href='../index.html'"id="logout">LOGOUT</button>
<a href="Milk(add&view).html"><button id="goback"><</button></a>
<div class="form-container">
    <h2>Latex Collection</h2>
    <form method="POST" action="" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            
        </div>

        <div class="form-group">
            <label for="latex">Latex Quantity (Kg):</label>
            <input type="number" id="latex" name="latex" step="0.1" required>
        </div>

        <button type="submit">Save</button>
    </form>
</div>
<script>
        window.onload = function () {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById("date").setAttribute("max", today);
        };
    </script>

    <?php
    include '../db.php'; // Database connection file
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date = $_POST['date'];
        $latex = $_POST['latex'];

        $sql = "INSERT INTO milk_collection (date, latex) VALUES ('$date', '$latex')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Record saved successfully!'); window.location.href='milk_view.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
        mysqli_close($conn);
    }
    ?>
</body>

</html>
</html>