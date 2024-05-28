<?php
session_start();
require_once "config.php";

if (isset($_POST['add_notice'])) {
    $title = $_POST['title'];
    $notice = $_POST['description'];

    $query = "INSERT INTO notice (title, body) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $title, $notice);

    // Execute the insert query
    if ($stmt->execute()) {
        echo "<script>alert('Notice inserted successfully.');</script>";
    } else {
        echo "<script>alert('Error inserting notice: " . $stmt->error . "');</script>";
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
    <title>Notice</title>
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
                <div class="midbar-text">Add Notice</div>
            </div>
            <div class="changeP">
                <form action="" method="post">
                   <table>
                    <tr>
                        <td>
                        <label for="title">Notice Title:</label>
                        </td>
                        <td>
                        <input type="text" name="title" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label for="description">Notice Description:</label>
                        </td>
                        <td>
                        <textarea name="description" rows="4" cols="50" required></textarea>
                        </td>
                    </tr>
                   </table>
                
                <div class="button">
                <input type="submit" name="add_notice" value="Add Notice" class="btnS">
                </div>
                </form>
            </div>
            
        </div>
    </div>
</body>

</html>
