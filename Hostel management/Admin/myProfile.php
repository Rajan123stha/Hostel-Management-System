<?php
session_start();
require_once "config.php";
$aid = $_SESSION['username'];

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $contact = $_POST['number'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $post = $_POST['post'];
    $address = $_POST['address'];

    $query = "UPDATE admin SET name=?, phone=?, age=?, gender=?, email=?, post=?, address=? WHERE username=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param('ssssssss', $name, $contact, $age, $gender, $email, $post, $address, $aid);
    if($stmt->execute()){

    
    echo "<script>alert('Profile updated Successfully');</script>";
    }
}

// Fetch student information from the database
$ret = "SELECT * FROM admin WHERE username=?";
$stmt = $conn->prepare($ret);
$stmt->bind_param('s', $aid);
$stmt->execute();
$res = $stmt->get_result();
$adminData = $res->fetch_assoc();
//echo "<script>alert('$aid');</script>";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/profile.css">


</head>

<body>
    
    <?php
    include('Include/header.php');
    ?>
    <div class="body">
        <?php
        include('Include/sidebar.php');
        ?>
        <div class="profile">
            <div class="mid-head">

                <div class="midbar-text"><?php echo $adminData['username']."'s  "; ?>Profile</div>
            </div>
            <div class="profile-section">
                <form action="" method="post">
                    <div class="info">
                        Profile Information
                    </div>
                    <hr>
                    <table>
                        <tr>
                            <td><label for="name">User Name</label></td>
                            <td><input type="text" id="username" name="username" class="input"
                                    value="<?php echo $adminData['username']; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Full Name:</label></td>
                            <td><input type="text" id="name" name="name" class="input"
                                    value="<?php echo $adminData['name']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Contact Number:</label></td>
                            <td><input type="number" id="number" name="number" class="input" 
                            value="<?php echo $adminData['phone']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Age:</label></td>
                            <td><input type="number" id="age" name="age" class="input"
                            value="<?php echo $adminData['age']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Email Id:</label></td>
                            <td><input type="email" id="email" name="email" class="input"
                            value="<?php echo $adminData['email']; ?>"></td>
                        </tr>
                
                        <tr>
                            <td> <label for="name">Post:</label></td>
                            <td><input type="text" id="post" name="post" class="input"
                            value="<?php echo $adminData['post']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Address:</label></td>
                            <td><input type="text" id="address" name="address" class="input"
                            value="<?php echo $adminData['address']; ?>"></td>
                        </tr>
                        
                        <tr>
                            <td> <label for="name">Gender:</label></td>
                            <td><select id="gender" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                    value="<?php echo $adminData['gender']; ?>"
                                </select></td>
                        </tr>
            
                    </table>

                    <div class="buttons">
                        <div class="button1"><input type="submit" Value="Update" name="update" class="btns"></div>
                        <div class="button2"><input type="submit" Value="Cancel" name="cancel" class="btns"></div>
                    </div>



                </form>
            </div>
        </div>


    </div>
</body>

</html>