<?php

require_once "config.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //form data
    $sname = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['number']);
    $college = trim($_POST['college']);
    $email = trim($_POST['email']);
    $parents = trim($_POST['parents']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
        echo "<script>alert('$username_err');</script>";
    } elseif (strlen(trim($_POST["username"])) <= 5) {
        $username_err = "Username must be more than 5 characters";
        echo "<script>alert('$username_err');</script>";
    } elseif (!preg_match('/\w/', trim($_POST["username"]))) {
        $username_err = "Username must contain at least one letter or digit";
        echo "<script>alert('$username_err');</script>";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
    
            // Set the value of param username
            $param_username = trim($_POST['username']);
    
            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                    echo "<script>alert('$username_err');</script>";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong";
            }
        }
    }
    




    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

    // Check for confirm password field
    if (trim($_POST['password']) != trim($_POST['cpassword'])) {
        $password_err = "Passwords should match";
    
        echo "<script>alert('$password_err');</script>";

    }

    //check if the the other information are filled or not
    if (empty($sname) && empty($address) && empty($phone) && empty($email) && empty($dob) && empty($college) && empty($parents) && empty($gender)) {
        $err = "All information needs to be filled!";
    } elseif (strlen($phone) != 10) {
        $err = "Phone number must be 10 digit";
    } else {

    }
    // Now, proceed to insert student data into the "student" table in the same database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($err)) {
        $sql1 = "INSERT INTO student (username, sname, phone, dob, email, gender,  address, pnumber,college_name) VALUES (?, ?, ?, ?, ?,?, ?, ?, ?)";
        $stmt1 = mysqli_prepare($conn, $sql1);
        if ($stmt1) {
            mysqli_stmt_bind_param($stmt1, "sssssssss", $username, $sname, $phone, $dob, $email, $gender, $address, $parents, $college);

            // Try to execute the query
            if (!mysqli_stmt_execute($stmt1)) {
                echo "Something went wrong while storing student information...";
            }
        }
        mysqli_stmt_close($stmt1);
    }
    // If there were no errors, go ahead and insert into the database
    if (empty($username_err) && empty($password_err) && empty($err)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set these parameters
            $param_username = $username;
            $param_password = $hashed_password;
            echo '<script>alert("Succesfully registered..")</script>';

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");

            } else {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }

    if (!empty($err)) {
        echo "<script>alert('$err');</script>";
    }

    mysqli_close($conn);

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <div class="login">
        <nav class="navbar">
            <div class="heading">Hostel Management System</div>
        </nav>

        <div class="register">
            <form action="" method="post">
                <div class="info">
                    Student Registration
                </div>
                <hr>
                <table>
                    <tr>
                        <td><label for="">Username:</label></td>
                        <td><input type="text" id="username" name="username" class="input"></td>
                    </tr>
                    <tr>
                        <td> <label for="name">Full Name:</label></td>
                        <td><input type="text" id="name" name="name" class="input"></td>
                    </tr>
                    <tr>
                        <td> <label for="number">Contact Number:</label></td>
                        <td><input type="number" id="number" name="number" class="input"></td>
                    </tr>
                    <tr>
                        <td> <label for="email">Email Id:</label></td>
                        <td><input type="email" id="email" name="email" class="input"></td>
                    </tr>
                    <tr>
                        <td> <label for="dob">Date of birth:</label></td>
                        <td><input type="date" id="dob" name="dob" class="input"></td>
                    </tr>
                    <tr>
                        <td> <label for="college">College Name:</label></td>
                        <td><input type="text" id="college" name="college" class="input"></td>
                    </tr>
                    <tr>
                        <td> <label for="address">Address:</label></td>
                        <td><input type="text" id="address" name="address" class="input"></td>
                    </tr>
                    <tr>
                    <tr>
                        <td> <label for="gender">Gender:</label></td>
                        <td><select id="gender" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>

                            </select></td>
                    </tr>
                    <td> <label for="parents">Parents Number:</label></td>
                    <td><input type="text" id="parents" name="parents" class="input"></td>
                    </tr>
                    <tr>
                        <td> <label for="password">Password:</label></td>
                        <td><input type="password" id="password" name="password" class="input"></td>
                    </tr>
                    <td> <label for="password">Confirm Password:</label></td>
                    <td><input type="password" id="cpassword" name="cpassword" class="input"></td>
                    </tr>
                </table>
                <div class="button"><input type="submit" Value="register" class="btns"></div>
                <div class="bottom-text">Already registered? <a href="login.php"> Login Here</a></div>

            </form>
        </div>
    </div>
</body>

</html>