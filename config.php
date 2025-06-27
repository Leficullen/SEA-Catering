<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "seacusers_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    error_log("Connection failed: ". $conn->connect_error);
    exit();
}
