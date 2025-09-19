<?php
/**
 * Database Configuration for LBC Task Management System
 */

// Database connection parameters
define('DB_HOST', 'localhost');
define('DB_NAME', 'lbc_tm_db');
define('DB_USER', 'root');  // Default XAMPP MySQL username
define('DB_PASS', '');      // Default XAMPP MySQL password (empty)
define('DB_CHARSET', 'utf8mb4');

/**
 * Create database connection
 * @return PDO|null Returns PDO connection or null on failure
 */
function getDatabaseConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        return null;
    }
}

/**
 * Test database connection
 * @return bool Returns true if connection successful
 */
function testDatabaseConnection() {
    $pdo = getDatabaseConnection();
    return $pdo !== null;
}
?>
