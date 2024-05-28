<?php
// This script will handle login

session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("location: dashboard.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$err = "";

// If the request method is POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter username and password";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }

    if (empty($err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;

        // Try to execute this statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, start the session and redirect to dashboard
                        $_SESSION['username'] = $username;
                        $_SESSION["loggedin"] = true;
                        header("location: dashboard.php");
                        exit;
                    } else {
                        // Password is incorrect
                        $err = "Invalid username or password";
                    }
                }
            } else {
                // User not found
                $err = "User not found";
            }
        } else {
            // Database or statement execution error
            $err = "Database error. Please try again later.";
        }
    }
}

// Display the error message (if any)
if (!empty($err)) {
    echo "<script>alert('$err');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>login</title>
</head>

<body>
    <div class="login">
        <nav class="navbar">
            <div class="heading">Hostel Management System</div>
        </nav>
        <div class="body">
            <?php
            include('Include/sideLogin.php');
            ?>
            <div class="midbar">
                <div class="mid-div">
                    <div class="midbar-text">User Login</div>
                </div>
                <div class="form">
                    <form action="" method="post">
                        <label for="email">Username</label>
                        <input type="text" id="username" name="username" placeholder="User" class="input">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="input">
                        <div class="button">
                            <input type="submit" value="Login" class="btnS">
                        </div>
                        <span> <a href="register.php">Register</a></span>

                    </form>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
