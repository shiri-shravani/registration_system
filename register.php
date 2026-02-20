<?php
if(isset($_POST['submit'])){
    include 'config.php'; // connect to DB

    // Get form data and sanitize
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure password

    // Check if email already exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check);

    if($result->num_rows > 0){
        $msg = "Email already registered!";
    } else {
        // Insert user into database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if($conn->query($sql) === TRUE){
            $msg = "Registration successful!";
        } else {
            $msg = "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px #00000033;
            width: 400px;
        }
        input[type=text], input[type=email], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <?php
if(isset($msg)){
    echo "<p style='color:green;text-align:center;'>$msg</p>";
}
?>
        <form action="register.php" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" required placeholder="Enter your name">

            <label for="email">Email</label>
            <input type="email" name="email" required placeholder="Enter your email">

            <label for="password">Password</label>
            <input type="password" name="password" required placeholder="Enter your password">

            <input type="submit" name="submit" value="Register">
        </form>
    </div>
</body>
</html>