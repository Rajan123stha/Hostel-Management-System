<?php
session_start();
require_once "config.php";
$aid = $_SESSION['username'];

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $contact = $_POST['number'];
    $b_date = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $college = $_POST['college'];
    $parent = $_POST['parents_n'];
    $address = $_POST['address'];

    // Validate Date of Birth
    if (!validateDate($b_date) || isFutureDate($b_date)) {
        echo "<script>alert('Invalid Date of Birth. Please use a valid past date.');</script>";
    } else {
        $query = "UPDATE student SET sname=?, phone=?, dob=?, gender=?, email=?, college_name=?, pnumber=?, address=? WHERE username=?";
        $stmt = $conn->prepare($query);
        $rc = $stmt->bind_param('sssssssss', $name, $contact, $b_date, $gender, $email, $college, $parent, $address, $aid);
        if ($stmt->execute()) {
            echo "<script>alert('Profile updated Successfully');</script>";
        }
    }
}

// Fetch student information from the database
$ret = "SELECT * FROM student WHERE username=?";
$stmt = $conn->prepare($ret);
$stmt->bind_param('s', $aid);
$stmt->execute();
$res = $stmt->get_result();
$studentData = $res->fetch_assoc();

function validateDate($date)
{
    $dateParts = explode('-', $date);
    if (count($dateParts) != 3) {
        return false;
    }

    list($year, $month, $day) = $dateParts;
    return checkdate($month, $day, $year);
}

function isFutureDate($date)
{
    $today = date('Y-m-d');
    return ($date > $today);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/register.css">
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

                <div class="midbar-text">
                    <?php echo $studentData['username'] . "'s  "; ?>Profile
                </div>
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
                                    value="<?php echo $studentData['username']; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Full Name:</label></td>
                            <td><input type="text" id="name" name="name" class="input"
                                    value="<?php echo $studentData['sname']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Contact Number:</label></td>
                            <td><input type="number" id="number" name="number" class="input"
                                    value="<?php echo $studentData['phone']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Date of birth:</label></td>
                            <td><input type="date" id="dob" name="dob" class="input"
                                    value="<?php echo $studentData['dob']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Email Id:</label></td>
                            <td><input type="email" id="email" name="email" class="input"
                                    value="<?php echo $studentData['email']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Room Number:</label></td>
                            <td><input type="number" id="room" name="room" class="input"
                                    value="<?php echo $studentData['room_number']; ?>" readonly></td>
                        </tr>
                        <tr>
                            <td> <label for="name">College Name:</label></td>
                            <td><input type="text" id="college" name="college" class="input"
                                    value="<?php echo $studentData['college_name']; ?>"></td>
                        </tr>
                        <tr>
                            <td> <label for="name">Address:</label></td>
                            <td><input type="text" id="address" name="address" class="input"
                                    value="<?php echo $studentData['address']; ?>"></td>
                        </tr>
                        <tr>
                        <tr>
                            <td> <label for="name">Gender:</label></td>
                            <td><select id="gender" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                    value="
                                    <?php echo $studentData['gender']; ?>"
                                </select></td>
                        </tr>
                        <td> <label for="name">Parents Number:</label></td>
                        <td><input type="number" id="parents_n" name="parents_n" class="input"
                                value="<?php echo $studentData['pnumber']; ?>"></td>
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