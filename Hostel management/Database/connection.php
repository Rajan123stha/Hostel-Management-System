<?php
    //connection 
    $serverName="localhost";
    $userName="root";
    $password="";
    $database="Hostel";
    //create connection
    $con=mysqli_connect($serverName,$userName,$password,$database);
    //crate table student to store info about student
    $sql="CREATE Table Student(
        sid INT PRIMARY KEY,
        sname VARCHAR(255),
        gender VARCHAR(10)
        sphone BIGINT,
        dob DATE,
        address VARCHAR(255),
        parents_number BIGINT,
        college_name VARCHAR(255),
        room_number VARCHAR(10)
    )";
    $result=mysqli_query($con,$sql);
//create table Admin for warden and owner
    $sql1="CREATE Table Admin(
        id INT PRIMARY KEY,
        name VARCHAR(255),
        phone BIGINT,
        age INT,
        address VARCHAR(255),
        password VARCHAR(255) UNIQUE,
        post VARCHAR(50)
    )";
    $result1=mysqli_query($con,$sql1);
//create table Room to store info about rooms
    $sql2="CREATE TABLE Room(
        room_number VARCHAR(10) PRIMARY KEY,
        floor INT,
        size INT,
        room_status BOOLEAN
    )";
    
    $result2=mysqli_query($con,$sql2);

    //create table Admit to store info about admission of student
    $sql3="CREATE TABLE Admit(
        name VARCHAR(255),
        sid INT,
        date DATE
    )";
    $result3=mysqli_query($con,$sql3);
    
//create table allocate to store the info allocation of room 
$sql4="CREATE TABLE Allocate(
    name VARCHAR(255),
    sid INT,
    amount INT,
    room_number VARCHAR(10)
)";
    $result4=mysqli_query($con,$sql4);



    if(!$con){
        die("Failed to connect:".mysqli_connect_error());
    }
    else{
        echo "connection was succesfull";
    }




?>