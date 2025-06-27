<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_name = $_POST['name'] ??'';
  $_testimony = $_POST['testimony'] ??'';

  if (empty($_name) || empty($_testimony)) {
      $_SESSION['message'] = "Name and Testimony must be filled";
      $_SESSION['message_type'] = "error";
      header("Location: index.php#testimoni");
      exit();
  }

  $stmt = $conn->prepare("INSERT INTO testimony (name, testimony) VALUES (?,?)") ;

  if ($stmt) {
    $stmt->bind_param("ss", $_name, $_testimony);

    if ($stmt->execute()) {
        $_SESSION['message'] = "";
        $_SESSION['message_type'] = "success";
        header ("Location: index.php#testimoni");
        exit();
    }
    $stmt->close();
  } 
} else {
    header("Location: index.php#testimoni");
    exit();
}
?>
