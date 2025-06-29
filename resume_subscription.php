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
}

    if ($subscription_id) {
        $current_status_sql = "SELECT status FROM subscription WHERE id = ? AND email = ?";
        $stmt_current_status = $conn->prepare($current_status_sql);
        if ($stmt_current_status) {
            $stmt_current_status->bind_param("is", $subscription_id, $user_email);
            $stmt_current_status->execute();
            $result_current_status = $stmt_current_status->get_result();
            $current_subscription_data = $result_current_status->fetch_assoc();
            $stmt_current_status->close();

            $old_status = $current_subscription_data['status'] ?? '';

            $new_status = 'active';
            if ($old_status === 'paused')  {
                $new_status = 'active';
            } elseif ($old_status === 'cancelled') {
                $new_status = 'reactivated';
            }
            
        $stmt = $conn->prepare("UPDATE subscription SET status = ?, pause_start_date = NULL, pause_end_date = NULL WHERE id = ? AND email = ?");

        if ($stmt) {
            $stmt->bind_param("sis", $new_status, $subscription_id, $user_email);
            if ($stmt->execute()) {
                if ($new_status === 'reactivated') {
                    $_SESSION ['message'] = "Your subscription has been reactivated.";
                } else {
                    $_SESSION ['message'] = "Your subscription has been successfully resumed.";
                }
                $_SESSION['message_type'] = "success";
                header("Location: user_page.php");
                exit();
            } else {
                $_SESSION['message'] = "Error resuming subscription: " . $stmt->error;
                $_SESSION['message_type'] = "error";
                header("Location: user_page.php");
                exit();
            }
            $stmt-> close();
        } else {
            $_SESSION['message'] = "Database statement preparation failed.";
            $_SESSION['message_type'] = "error";
            header("Location: user_page.php");
            exit();
        }
    } else {
         header("Location: user_page.php");
    exit();
    }
}
        