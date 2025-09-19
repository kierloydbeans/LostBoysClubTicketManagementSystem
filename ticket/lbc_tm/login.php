<?php
session_start();
require_once 'config/database.php';

// Initialize response variables
$error_message = '';
$success_message = '';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    
    // Validate input
    if (empty($username)) {
        $error_message = 'Please enter a username.';
    } else {
//        try {
            $pdo = getDatabaseConnection();

            if (!$pdo) {
                throw new Exception('Database connection failed.');
            }

            // Get user information
            $stmt = $pdo->prepare("
                SELECT id, username, first_name, last_name, role, is_active
                FROM login 
                WHERE username = ? OR email = ?
            ");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if (!$user) {
                $error_message = 'Username not found.';
            } elseif (!$user['is_active']) {
                $error_message = 'Your account has been deactivated. Please contact administrator.';
            } else {
                // Update last login time
                $stmt = $pdo->prepare("
                    UPDATE login 
                    SET last_login = NOW() 
                    WHERE id = ?
                ");
                $stmt->execute([$user['id']]);

                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['logged_in'] = true;
                $_SESSION['login_time'] = time();

                // Redirect to dashboard
                header('Location: dashboard.php');
                exit();
            }
            }
        /*} catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $error_message = 'An error occurred during login. Please try again.';
        }*/
    }


// If there's an error, redirect back to login page with error
if (!empty($error_message)) {
    $_SESSION['login_error'] = $error_message;
    header('Location: login_page.php');
    exit();
}

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: dashboard.php');
    exit();
}

// If no POST request, redirect to login page
header('Location: login_page.php');
exit();
