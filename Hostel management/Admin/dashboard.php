
<?php
require_once "config.php";

// Fetch notice details from the "notice"
$query = "SELECT * FROM notice";
$result = mysqli_query($conn, $query);

// Handle notice deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_notice"])) {
    $notice_id = $_POST["delete_notice"];
    $delete_query = "DELETE FROM notice WHERE SN = $notice_id";
    mysqli_query($conn, $delete_query);
    header("Location: dashboard.php"); // Redirect to the dashboard after deletion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/dashboard.css">

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
                <div class="midbar-text">Dashboard</div>
            </div>
            <div class="mid-body">
                <div class="profile">
                    <a href="registerAdmin.php"><span>Add Admin</span></a>
                </div>
                <div class="room">
                    <a href="complains.php"><span>Complains</span></a>
                </div>

            </div>
            <hr>
            <div class="notices">
            <?php
            // Display notices and delete buttons
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="notice">';
                echo '<div class="notice-head">' . htmlspecialchars($row['title']) . '</div>';
                echo '<div class="notice-body">';
                echo '<p class="notice-text">' . htmlspecialchars($row['body']) . '</p>';
                echo '</div>';
                echo '<form method="post" class="delete-form">';
                echo '<input type="hidden" name="delete_notice" value="' . $row['SN'] . '">';
                echo '<button type="submit" class="delete-button">Delete</button>';
                echo '</form>';
                echo '</div>';
            }

            if (mysqli_num_rows($result) <= 0) {
                echo '<div class="notice">';
                echo '<div class="notice-head">No Notices Found</div>';
                echo '<div class="notice-body">';
                echo '<p class="notice-text">There are no notices to display.</p>';
                echo '</div>';
                echo '</div>';
            }

            mysqli_close($conn);
            ?>
        </div>
            <hr>
        </div>
    </div>
</body>

</html>