<?php
session_start();
require_once "config.php";

if (isset($_POST['assign'])) {
    $room = $_POST['room_no'];
    $username = $_POST['s_username'];
    $amount = $_POST['amount'];

    if ($amount < 0) {
        echo "<script>alert('Amount cannot be negative!');</script>";
    } else {
        $query = "INSERT INTO assign (username, amount, room_number) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $username, $amount, $room);

        if ($stmt->execute()) {
            // Update the room_number column in the student table
            $updateQuery = "UPDATE student SET room_number = ? WHERE username = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('ss', $room, $username);

            if ($updateStmt->execute()) {
                echo "<script>alert('Room Assigned!');</script>";
            } else {
                echo "<script>alert('Error updating student room: " . $updateStmt->error . "');</script>";
            }

            $updateStmt->close();
        } else {
            echo "<script>alert('Error assigning room: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
}

$sql = "SELECT username FROM student WHERE username NOT IN (SELECT DISTINCT username FROM assign)";
$result = mysqli_query($conn, $sql);
$usernames = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $usernames[] = $row['username'];
    }
}

$query = "SELECT room_number FROM room WHERE room_number NOT IN (SELECT DISTINCT room_number FROM assign)";
$result = mysqli_query($conn, $query);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assignRoom</title>
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
                <div class="midbar-text">Assign Room</div>
            </div>
            <div class="changeP">
                <form action="" method="post">
                    <table>
                        <tr>
                            <td><label for="room_number">Room Number:</label></td>
                            <td>
                                <select name="room_no" required>
                                    <?php
                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $roomNumber = $row['room_number'];
                                            echo "<option value='$roomNumber'>$roomNumber</option>";
                                        }
                                    } else {
                                        echo '<option value="" disabled>No available rooms</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="student_username">Student Username:</label></td>
                            <td>
                                <select name="s_username" required>
                                    <?php
                                    if (!empty($usernames)) {
                                        foreach ($usernames as $username) {
                                            echo "<option value=\"$username\">$username</option>";
                                        }
                                    } else {
                                        echo '<option value="" disabled>No available usernames</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="fee_amount">Fee Amount:</label></td>
                            <td><input type="number" name="amount" required></td>
                        </tr>
                    </table>
                    <div class="button">
                        <input type="submit" name="assign" value="Assign Room" class="btnS">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>