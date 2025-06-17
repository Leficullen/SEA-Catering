<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"/>
    <style>
      body {
        font-family: 'poppins',sans-serif;
      }
    </style>
</head>
<body>
    <div class="box">
        <h1>Welcome, <span><?= $_SESSION['name']; ?> </span></h1>
        <p>This is an <span>Admin Page </span> </p>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>