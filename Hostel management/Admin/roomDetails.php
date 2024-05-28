<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "config.php";

    $roomNumber = $_POST["room_number"];
    $floor = $_POST["floor"];

    // Check if the room number already exists
    $roomExistsQuery = "SELECT room_number FROM room WHERE room_number = ?";
    $roomExistsStmt = $conn->prepare($roomExistsQuery);
    $roomExistsStmt->bind_param('s', $roomNumber);
    $roomExistsStmt->execute();
    $roomExistsResult = $roomExistsStmt->get_result();

    if ($roomExistsResult->num_rows > 0) {
        echo "<script>alert('Error: Room number already exists');</script>";
    } else {
        // Perform database insert here
        $insertQuery = "INSERT INTO room (room_number, floor) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('ss', $roomNumber, $floor);

        if ($insertStmt->execute()) {
            echo "<script>alert('Room added successfully');</script>";
        } else {
            echo "<script>alert('$insertStmt->error');</script>";
        }
    }
    
   
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/roomDetails.css">

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
                <div class="midbar-text">Room Details</div>
            </div>
            <div class="table">
                <table>
                    <tr>
                        <th>S.N.</th>
                        <th>Room no.</th>
                        <th>Student Name</th>
                        <th>Amount</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                    // Database connection
                    require_once "config.php";

                    // Fetch information of assigned rooms from the "assign" table
                    $query = "SELECT * FROM assign";
                    $result = mysqli_query($conn, $query);

                    // Check if there are any assigned rooms
                    if (mysqli_num_rows($result) > 0) {
                        $serialNumber = 1;

                        // Loop through the results and display them in the table
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $serialNumber . '</td>';
                            echo '<td>' . htmlspecialchars($row['room_number']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['amount']) . '</td>';
                            echo '<td><a href="delete.php?id=' . $row['id'] . '">Delete</a></td>';
                            echo '</tr>';
                            
                            $serialNumber++;
                        }
                    } else {
                        echo '<tr><td colspan="4">No assigned rooms found.</td></tr>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </table>
                <div class="add_room">
                <form method="POST" action="">
                    <label for="room_number">Room Number:</label>
                    <input type="text" name="room_number" required><br>
                    <label for="floor">Floor:</label>
                    <input type="text" name="floor" required><br>
                    <button type="submit" class="btnS">Add Room</button>
                    </div>
            </div>
            
        </div>
    </div>
</body>

</html>