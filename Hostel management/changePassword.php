<?php
session_start();
require_once "config.php";
$aid = $_SESSION['username'];
$err = "";

if (isset($_POST['change'])) {
    $currentP = $_POST['current_password'];
    $newP = $_POST['new_password'];
    $confirmP = $_POST['confirm_password'];

    if ($newP !== $confirmP) {
        $err = "New password and confirm password do not match.";
    }

    // Perform a query to get the hashed password from the database
    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $aid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $hashed_password);
        mysqli_stmt_fetch($stmt);

        // Verify the current password
        if (password_verify($currentP, $hashed_password)) {
            // Hash the new password
            $newHashedPassword = password_hash($newP, PASSWORD_BCRYPT);

            // Update the password in the database
            $updateQuery = "UPDATE users SET password = ? WHERE username = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ss", $newHashedPassword, $aid);

            if (mysqli_stmt_execute($updateStmt)) {
                echo "<script>alert('Password updated successfully');</script>";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }

            mysqli_stmt_close($updateStmt); // Close the prepared statement
        } else {
            $err = "Incorrect current password";
        }
    } else {
        $err = "User not found.";
    }

    if (!empty($err)) {
        echo "<script>alert('$err');</script>";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/changePassword.css">
</head>

<body>
    <?php
    include('Include/header.php');
    ?>
    <div class="body">
        <?php
        include('Include/sidebar.php');
        ?>
        <div class="dashboard">
            <div class="mid-head">
                <div class="midbar-text">Change Password</div>
            </div>
            <div class="changeP">
                <form action="" method="post">

                    <table>
                        <tr>
                            <td>
                                <label for="current_password">Current Password:</label>
                            </td>
                            <td>
                                <input type="password" name="current_password" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="new_password">New Password:</label>
                            </td>
                            <td>
                                <input type="password" name="new_password" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="confirm_password">Confirm New Password:</label>
                            </td>
                            <td>
                                <input type="password" name="confirm_password" required><br>
                            </td>
                        </tr>
                    </table>
                    <div class="button">
                        <input type="submit" name="change" value="Change Password" class="btnS">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>