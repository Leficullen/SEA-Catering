<?php

session_start();
require_once 'config.php';

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data); 
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); 
    return $data;
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['register'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['register_error'] = 'Invalid CSRF token.';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }
    unset($_SESSION['csrf_token']);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input(strtolower($_POST['email'] ?? ''));
    $passwordRaw = trim($_POST['password'] ?? '');
    $role = sanitize_input($_POST['role'] ?? '');
    $admin_code = sanitize_input($_POST['admin_code'] ?? '');

    if (empty($name) || empty($email) || empty($passwordRaw) || empty($role)) {
        $_SESSION['register_error'] = 'Please fill all of the fields.';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = 'Email Format is Invalid';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }

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

    $stmt_check = $conn->prepare("SELECT email FROM userss WHERE email = ?");
    if ($stmt_check === false) {
        error_log("Failed to prepare statement for email check: " . $conn->error);
        $_SESSION['register_error'] = 'A system error occurs, please try again!';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $checkEmail = $stmt_check->get_result();
    $stmt_check->close();

    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email has been registered!';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }
    $stmt_insert = $conn->prepare("INSERT INTO userss (name, email, password, role) VALUES (?, ?, ?, ?)");
    if ($stmt_insert === false) {
        error_log("Failed to prepare statement for insert: " . $conn->error);
        $_SESSION['register_error'] = 'Terjadi kesalahan sistem, silakan coba lagi.';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }
    $stmt_insert->bind_param("ssss", $name, $email, $password, $role);
    if ($stmt_insert->execute()) {
        header("Location: login.php");
        exit();
    } else {
        error_log("Error executing insert statement: " . $stmt_insert->error);
        $_SESSION['register_error'] = 'Register failed, please try again!';
        $_SESSION['active_form'] = 'register';
        header("Location: login.php");
        exit();
    }
    $stmt_insert->close();

}

if (isset($_POST['login'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['login_error'] = 'Invalid CSRF token.';
        $_SESSION['active_form'] = 'login';
        header("Location: login.php");
        exit();
    }
    
    unset($_SESSION['csrf_token']);
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    $email = sanitize_input(strtolower($_POST['email'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = 'Please fill all of the fields!';
        $_SESSION['active_form'] = 'login';
        header("Location: login.php");
        exit();
    }

    $stmt_login = $conn->prepare("SELECT * FROM userss WHERE email = ?");
    if ($stmt_login === false) {
        error_log("Failed to prepare statement for login: " . $conn->error);
        $_SESSION['login_error'] = 'A system error occured, please try again!';
        $_SESSION['active_form'] = 'login';
        header("Location: login.php");
        exit();
    }
    $stmt_login->bind_param("s", $email);
    $stmt_login->execute();
    $result = $stmt_login->get_result();
    $stmt_login->close();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: auth_redirect.php");
            exit();
        }
    }
    $_SESSION['login_error'] = 'Incorrect Email or Password.';
    $_SESSION['active_form'] = 'login';
    header("Location: login.php");
    exit();
}