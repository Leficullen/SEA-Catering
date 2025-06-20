<?php

session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $passwordRaw = $_POST['password'];
    $role = $_POST['role'];
    $admin_code = $_POST['admin_code']??'';

    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $passwordRaw)) {
        $_SESSION['register_error'] = 'Password must be at least 8 characters long and include uppercase, lowercase, number and symbol';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }

    if($role === 'admin' && $admin_code !== '27087736') {
        $_SESSION['register_error'] = 'Invalid Admin Code';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }

    $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

    $checkEmail = $conn->query("SELECT email FROM userss WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    } 

    $conn->query("INSERT INTO userss (name, email, password, role) VALUES ('$name', '$email', '$password', '$role') ");

    header("Location: login.php");
    exit();

}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM userss WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if ($user['role'] === 'admin') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        }
    }
}
$_SESSION['login_error'] = 'Incorrect email or password';
$_SESSION['active_form'] = 'login';
header("Location: login.php");
exit();

?>



