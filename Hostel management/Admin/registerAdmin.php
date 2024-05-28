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
    $email = trim($_POST['email']);
    $post = trim($_POST['post']);
    $gender = trim($_POST['gender']);
    $age = trim($_POST['age']);

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
        echo "<script>alert('$username_err');</script>";

    } else {
        $sql = "SELECT admin_id FROM admin_log WHERE username = ?";
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




    // Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
        echo "<script>alert('$password_err');</script>";

    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
        echo "<script>alert('$password_err');</script>";

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
        $sql1 = "INSERT INTO Admin (username, name, phone, gender, email, age, address,post) VALUES (?, ?, ?, ?, ?,?, ?, ?)";
        $stmt1 = mysqli_prepare($conn, $sql1);
        if ($stmt1) {
            mysqli_stmt_bind_param($stmt1, "ssssssss", $username, $sname, $phone, $gender, $email,$age, $address, $post);

            // Try to execute the query
            if (!mysqli_stmt_execute($stmt1)) {
                echo "Something went wrong while storing student information...";
            }
        }
        mysqli_stmt_close($stmt1);
    }
    // If there were no errors, go ahead and insert into the database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($err)) {
        $sql = "INSERT INTO admin_log (username, password) VALUES (?, ?)";
        //$sql1 = "INSERT INTO student (sname, address) VALUES ($sname,$address)";
        //$stmt1= mysqli_query($conn, $sql1);
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set these parameters
            $param_username = $username;
            $param_password = $password;
            echo '<script>alert("Succesfully registered..")</script>';

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: dashboard.php");

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
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/register.css">
   
</head>

<body>
<?php
    include('Include/header.php');
    ?>
    <div class="body">
        <?php
        include('Include/sidebar.php');
        ?>

        <div class="register">
            <form action="" method="post">
                <div class="info">
                  Admin Registration
                </div>
                <hr>
                <table>
                    <tr>
                        <td><label for="username">Username:</label></td>
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
                        <td> <label for="age">Age:</label></td>
                        <td><input type="number" id="age" name="age" class="input"></td>
                    </tr>
                    <tr>
                        <td> <label for="address">Address:</label></td>
                        <td><input type="text" id="address" name="address" class="input"></td>
                    </tr>
                    <tr>
                    
                        <td> <label for="gender">Gender:</label></td>
                        <td><select id="gender" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>

                            </select></td>
                    </tr>
                    <tr>
                        <td> <label for="post">Post:</label></td>
                        <td><input type="text" id="post" name="post" class="input"></td>
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
            </form>
        </div>
    </div>
</body>

</html>