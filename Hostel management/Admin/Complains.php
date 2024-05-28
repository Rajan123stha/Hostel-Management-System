<?php
session_start();
require_once "config.php";

// Fetch complain details from the "complain" table
$query = "SELECT * FROM complain";
$result = mysqli_query($conn, $query);

// Handle complaint deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_complaint"])) {
    $complaint_id = $_POST["delete_complaint"];
    $delete_query = "DELETE FROM complain WHERE Cid = $complaint_id";
    mysqli_query($conn, $delete_query);
    header("Location: complains.php"); // Redirect to the complaints page after deletion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
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
                <div class="midbar-text">Complaints</div>
            </div>
            <div class="changeP">
                <div class="complains">
                    <?php
                    // Check if there are any complaints
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through the results and display them in the "complaints" section
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="complaint">';
                            echo '<div class="complaint-head">' . htmlspecialchars($row['title']) . '</div>';
                            echo '<div class="complaint-body">';
                            echo '<p class="complaint-text">' . htmlspecialchars($row['complain']) . '</p>';
                            echo '</div>';
                            echo '<form method="post" class="delete-form">';
                            echo '<input type="hidden" name="delete_complaint" value="' . $row['Cid'] . '">';
                            echo '<button type="submit" class="delete-button">Delete</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '<hr>';
                        }
                    } else {
                        echo '<div class="complaint">';
                        echo '<div class="complaint-head">No Complaints Found</div>';
                        echo '<div class="complaint-body">';
                        echo '<p class="complaint-text">There are no complaints to display.</p>';
                        echo '</div>';
                        echo '</div>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
