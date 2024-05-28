<?php
// Database connection
require_once "config.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the row from the "assign" table
    $query = "DELETE FROM assign WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Row deleted successfully, redirect back to the original page
        header("Location: roomDetails.php"); // Change this to the appropriate page name
        exit();
    } else {
        echo "Error deleting row: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>