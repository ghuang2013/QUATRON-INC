<?php

$connect = mysqli_connect("localhost","root","");
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "CREATE DATABASE IF NOT EXISTS Users2";
if (!$connect->query($sql)) {
    echo "Error creating database: " . $connect->error;
}

$select = mysqli_select_db($connect, 'Users2');
if (!$select) {
    echo 'Cannot select DB  '.mysqli_error($connect);
}

$table = "CREATE TABLE IF NOT EXISTS People (
    username VARCHAR(15) NOT NULL,
    password VARCHAR(15) NOT NULL,
    reg_date TIMESTAMP
)";

if (!$connect->query($table)) {
    echo "Error creating Table: " . $connect->error;
}

?>