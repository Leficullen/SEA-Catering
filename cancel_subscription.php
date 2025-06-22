<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subscription_id = $_POST['subscription_id'] ?? null;
    $user_email = $_SESSION['email'];

    if ($subscription_id) {
        $stmt = $conn->prepare("UPDATE subscription SET status = 'cancelled', cancellation_date = NOW() WHERE id = ? AND email = ?");
         if ($stmt) {
            $stmt->bind_param("is", $subscription_id, $user_email);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Your subscription has been successfully cancelled.";
                $_SESSION['message_type'] = "success";
                header("Location: user_page.php");
                exit();
            } else {
                $_SESSION['message'] = "Error cancelling subscription: " . $stmt->error;
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
        $_SESSION['message'] = "Subscription ID not provided.";
        $_SESSION['message_type'] = "error";
        header("Location: user_page.php");
        exit();
    }
} else {
    header("Location: user_page.php");
    exit();
}
?>

