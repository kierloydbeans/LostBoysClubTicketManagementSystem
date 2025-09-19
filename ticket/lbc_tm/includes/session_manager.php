<?php
/**
 * Session Management Utilities for LBC Task Management System
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Require user to be logged in, redirect to login if not
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.html');
        exit();
    }
}

/**
 * Check if user has specific role
 * @param string $role Required role
 * @return bool
 */
function hasRole($role) {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

/**
 * Check if user has any of the specified roles
 * @param array $roles Array of allowed roles
 * @return bool
 */
function hasAnyRole($roles) {
    if (!isLoggedIn() || !isset($_SESSION['role'])) {
        return false;
    }
    return in_array($_SESSION['role'], $roles);
}

/**
 * Require specific role, redirect if not authorized
 * @param string $role Required role
 */
function requireRole($role) {
    requireLogin();
    if (!hasRole($role)) {
        header('Location: unauthorized.php');
        exit();
    }
}

/**
 * Get current user information
 * @return array|null
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'first_name' => $_SESSION['first_name'] ?? null,
        'last_name' => $_SESSION['last_name'] ?? null,
        'role' => $_SESSION['role'] ?? null,
        'full_name' => ($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? ''),
        'login_time' => $_SESSION['login_time'] ?? null
    ];
}

/**
 * Logout user and destroy session
 */
function logout() {
    // Clear all session variables
    $_SESSION = array();
    
    // Delete session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    
    // Destroy session
    session_destroy();
}

/**
 * Check session timeout (optional security feature)
 * @param int $timeout_minutes Session timeout in minutes (default: 30)
 * @return bool True if session is valid, false if timed out
 */
function checkSessionTimeout($timeout_minutes = 30) {
    if (!isLoggedIn()) {
        return false;
    }
    
    $login_time = $_SESSION['login_time'] ?? 0;
    $timeout_seconds = $timeout_minutes * 60;
    
    if (time() - $login_time > $timeout_seconds) {
        logout();
        return false;
    }
    
    return true;
}
?>
