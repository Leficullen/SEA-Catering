<?php
session_start();

if(isset($_SESSION['email']) && isset($_SESSION['role'])) {
    if($_SESSION['role'] === 'admin') {
        header("Location:admin_page.php");
    } else {
        header("Location:user_page.php");
    }
}else {
    header("Location:login.php");

}
exit();
?>