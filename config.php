<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "seacusers_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

$conn = mysqli_connect("localhost", "root", "", "seacusers_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>