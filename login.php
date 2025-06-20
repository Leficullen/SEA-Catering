<?php

session_start();
if (isset($_SESSION['email'])) {
    header("Location: user_page.php");
    exit();
}

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"/>
    <style>
      body {
        font-family: 'poppins',sans-serif;
      }
    </style>
</head>
<body class="login">
    <div class="container">
        <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
            <form action="login_register.php" method="post">
                <h2>Login</h2>
                <?= showError($errors['login']); ?>
                <input type="email" name="email" placeholder="E-Mail" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Don't have an acoount? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>
        <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
            <form action="login_register.php" method="post">
                <h2>Register</h2>
                <?= showError($errors['register']); ?>
                <input type="text" name="name"  placeholder="Name" required>
                <input type="email" name="email" placeholder="E-Mail" required>
                <input type="password" name="password" placeholder="Password" required
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_].{8,}"
                    title="Password must be at least 8 characters long and include uppercase, lowercase, number and symbol">
                <select name="role" id="role" required>
                  <option value="">Select Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
                <input type="number" name="admin_code" placeholder="Admin Code (Required for Admin)">     
                <button type="submit" name="register">Register</button>
                <p>Already have an acoount? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
    
</body>
</html>