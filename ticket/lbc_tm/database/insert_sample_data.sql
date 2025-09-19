-- Insert sample data into login table
USE lbc_tm_db;

-- Sample users with hashed passwords (using bcrypt-like format for demonstration)
-- Note: In production, passwords should be properly hashed using PHP's password_hash() function
INSERT INTO login (username, email, password_hash, first_name, last_name, role, is_active) VALUES
('admin', 'admin@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System', 'Administrator', 'admin', TRUE),
('jsmith', 'john.smith@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Smith', 'manager', TRUE),
('mjohnson', 'mary.johnson@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mary', 'Johnson', 'employee', TRUE),
('rbrown', 'robert.brown@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Robert', 'Brown', 'employee', TRUE),
('swilson', 'sarah.wilson@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sarah', 'Wilson', 'manager', TRUE),
('dlee', 'david.lee@lbc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'David', 'Lee', 'employee', FALSE);

-- Note: All sample passwords are "password123" (hashed)
-- In a real application, users should set their own secure passwords
