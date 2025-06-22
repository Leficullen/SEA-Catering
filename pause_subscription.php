<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subscription_id = $_POST['subscription_id'] ?? null;
    $pause_start = $_POST['pause_start'] ?? null;
    $pause_end = $_POST['pause_end'] ?? null;
    $user_email = $_SESSION['email'];

    if ($subscription_id && $pause_start && $pause_end) {
         if (strtotime($pause_start) > strtotime($pause_end)) {
            $_SESSION['message'] = "Start date cannot be after end date.";
            $_SESSION['message_type'] = "error";
            header("Location: user_page.php");
            exit();
        }
        $stmt = $conn->prepare("UPDATE subscription SET status = 'paused', pause_start_date = ?, pause_end_date = ? WHERE id = ? AND email = ?");
        if ($stmt) {
            $stmt->bind_param("ssis", $pause_start, $pause_end, $subscription_id, $user_email);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Your subscription has been successfully paused.";
                $_SESSION['message_type'] = "success";
                header("Location: user_page.php");
                exit();
            } else {
                $_SESSION['message'] = "Error pausing subscription: " . $stmt->error;
                $_SESSION['message_type'] = "error";
                header("Location: user_page.php");
                exit();
            }
             $stmt->close();
        } else {
            $_SESSION['message'] = "Database statement preparation failed.";
            $_SESSION['message_type'] = "error";
            header("Location: user_page.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "All required fields for pausing subscription must be provided.";
        $_SESSION['message_type'] = "error";
        header("Location: user_page.php");
        exit();
    }
} else {
    header("Location: user_page.php");
    exit();
}
?>