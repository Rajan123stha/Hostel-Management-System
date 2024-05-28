<?php

require_once "config.php";

// Fetch notice details from the "notice"
$query = "SELECT * FROM notice";
$result = mysqli_query($conn, $query);
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
           <div class="title">Notices</div>
            <hr>
            <div class="notices">
            <?php
                // Check if there are any notices
                if (mysqli_num_rows($result) > 0) {
                    // Loop through the results and display them in the "notices" section
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="notice">';
                        echo '<div class="notice-head">' . htmlspecialchars($row['title']) . '</div>';
                        echo '<div class="notice-body">';
                        echo '<p class="notice-text">' . htmlspecialchars($row['body']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<hr>';
                    }
                } else {
                    echo '<div class="notice">';
                    echo '<div class="notice-head">No Notices Found</div>';
                    echo '<div class="notice-body">';
                    echo '<p class="notice-text">There are no notices to display.</p>';
                    echo '</div>';
                    echo '</div>';
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </div>
        
        </div>
    </div>
</body>

</html>