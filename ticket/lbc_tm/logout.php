<?php
require_once 'includes/session_manager.php';

// Logout the user
logout();

// Redirect to login page with success message
$_SESSION['logout_message'] = 'You have been successfully logged out.';
header('Location: login_page.php');
exit();
?>
