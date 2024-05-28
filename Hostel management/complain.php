<?php
session_start();
require_once "config.php";
if(isset($_POST['add_complain'])){
    $title=$_POST['title'];
    $complain=$_POST['description'];
    $query="INSERT INTO complain (title, complain) values(?,?)";
    $stmt=$conn->prepare($query);
    $stmt->bind_param('ss',$title,$complain);

    if($stmt->execute()){
        echo "<script>alert('Complain registered!!');</script>";
    }
    else{
        echo "<script>alert('Error Occur:$stmt->error .');</script>";
    }
}
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
                <div class="midbar-text">Register Complain</div>
            </div>
            <div class="message"><p>If you have any complain regarding hostel and its facility, you can send us your complain using form below:</p>
</div>
            <div class="changeP">
                <form action="" method="post">
                   <table>
                    <tr>
                        <td>
                        <label for="title">Complain Title:</label>
                        </td>
                        <td>
                        <input type="text" name="title" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label for="description">Complain Description:</label>
                        </td>
                        <td>
                        <textarea name="description" rows="4" cols="50" required></textarea>
                        </td>
                    </tr>
                   </table>
                
                <div class="button">
                <input type="submit" name="add_complain" value="Send Complain" class="btnS">
                </div>
                </form>
            </div>
            
        </div>
    </div>
</body>

</html>
