<?php
session_start();
require_once "config.php";
$aid = $_SESSION['username'];
$err="";
if (isset($_POST['change'])) {
    $currentP = $_POST['current_password'];
    $newP = $_POST['new_password'];
    $confirmP = $_POST['confirm_password'];

    if ($newP !== $confirmP) {
        die("New password and confirm password do not match.");
    }

    // Perform a query to check if the current password is correct
    $query = "SELECT password FROM admin_log WHERE username = '$aid'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $actualP= $row["password"];

        // Verify the current password
        if ($currentP===$actualP) {
            // Update the password in the database
            $NewPassword = $newP;
            $updateQuery = "UPDATE admin_log SET password = '$NewPassword' WHERE username = '$aid'";
            if (mysqli_query($conn, $updateQuery)) {
                echo "<script>alert('Password updated Successfully');</script>";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Incorrect current password');</script>";
        }
    } else {
        echo "User not found.";
    }
}

// Close the database connection
mysqli_close($conn);

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