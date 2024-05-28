<?php

$serverName="localhost";
    $userName="root";
    $password="";
    $database="hostel";
    //create connection
    $conn=mysqli_connect($serverName,$userName,$password,$database);
    
    if(!$conn){
        die("Failed to connect:".mysqli_connect_error());
    }
    

?>