<?php
session_start();
require_once 'config/database.php';

// Check if event ID is provided
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

// In a real application, you would fetch event details from the database
// For now, we'll use sample data
$event = [
    'id' => $event_id,
    'title' => 'Event Title',
    'date' => 'Date',
    'time' => '',
    'location' => 'Venue Name, City',
    'description' => 'This is a sample event description. In a real application, this would be pulled from your database.',
    'image' => 'images/logo.jpg',
    // Removed price and available tickets as per requirements
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process payment details
    $amount_paid = floatval($_POST['amount_paid'] ?? 0);
    $reference_number = trim($_POST['reference_number'] ?? '');
    $payment_datetime = trim($_POST['payment_datetime'] ?? '');
    $account_name = trim($_POST['account_name'] ?? '');
    $account_number = trim($_POST['account_number'] ?? '');
    
        // Validate input
    if (empty($reference_number) || empty($payment_datetime) || empty($account_name) || empty($account_number) || $amount_paid <= 0) {
        die('Please fill in all required fields with valid data.');
    }
    
    try {
        // Get database connection
        $pdo = new PDO("mysql:host=localhost;dbname=lbc_tm_db;charset=utf8mb4", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Start transaction
        $pdo->beginTransaction();

        // 1. Get event details
        $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$event_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            throw new Exception('Event not found');
        }

        // 2. Get user ID from session (you'll need to set this when user logs in)
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            throw new Exception('User not logged in');
        }

        // 3. Generate a unique ticket number
        $ticket_number = 'LBC-' . strtoupper(uniqid());

        // 4. Insert ticket into database
        $stmt = $pdo->prepare("
            INSERT INTO tickets (
                ticket_number, 
                event_id, 
                user_id, 
                ticket_type, 
                price, 
                purchase_date, 
                status, 
                payment_reference, 
                payment_date, 
                amount_paid, 
                account_name, 
                account_number
            ) VALUES (?, ?, ?, ?, ?, NOW(), 'confirmed', ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $ticket_number,
            $event_id,
            $user_id,
            'General Admission',
            $event['price'], // Get price from events table
            $reference_number,
            $payment_datetime,
            $amount_paid,
            $account_name,
            $account_number
        ]);

        // 5. Update available tickets count
        $stmt = $pdo->prepare("UPDATE events SET available_tickets = available_tickets - 1 WHERE id = ?");
        $stmt->execute([$event_id]);

        // Commit transaction
        $pdo->commit();

        // Redirect to thank you page with ticket number
        header('Location: thank_you.php?ticket_number=' . urlencode($ticket_number));
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        if (isset($pdo)) {
            $pdo->rollBack();
        }
        // Log the error (in a real app, you'd want to log this properly)
        error_log('Ticket purchase error: ' . $e->getMessage());
        
        // Show error message to user
        die('An error occurred while processing your ticket. Please try again.');
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Tickets - <?php echo htmlspecialchars($event['title']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .ticket-purchase {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(26, 26, 46, 0.9);
            border-radius: 10px;
            color: #fff;
        }

        .ticket-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .ticket-header h1 {
            color: #e94560;
            margin-bottom: 0.5rem;
        }

        .event-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .ticket-form {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .ticket-options {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .ticket-option {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .ticket-option:hover, .ticket-option.selected {
            border-color: #e94560;
            background: rgba(233, 69, 96, 0.1);
        }

        .ticket-option input[type="radio"] {
            margin-right: 0.75rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border-radius: 4px;
            border: 1px solid #444;
            background: #0f3460;
            color: #fff;
            margin-top: 0.5rem;
            font-size: 1rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #e94560;
            box-shadow: 0 0 0 2px rgba(233, 69, 96, 0.2);
        }

        /* Removed total-amount as it's no longer needed */

        .checkout-btn {
            width: 100%;
            padding: 1rem;
            background: #e94560;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .checkout-btn:hover {
            background: #d13354;
        }

        .event-details {
            margin: 2rem 0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <img src="images/logo.jpg" alt="LBC Logo" class="navbar-logo">
            <h1>Lost Boys Club</h1>
        </div>
        <nav class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="#">Tickets</a>
            <a href="#" class="account-link">Account</a>
            <span class="user-info">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] ?? 'Guest'); ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </nav>
    </header>

    <main class="ticket-purchase">
        <div class="ticket-header">
            <h1>Purchase Tickets</h1>
            <p>Complete your purchase below</p>
        </div>

        <div class="event-info">
            <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="event-image">
            <h2><?php echo htmlspecialchars($event['title']); ?></h2>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($event['time']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
            
            <div class="event-details">
                <h3>Event Details</h3>
                <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
            </div>
        </div>

        <form class="ticket-form" method="POST" action="">
            <div class="form-group">
                <label for="amount_paid">Amount Paid (₱):</label>
                <input type="number" id="amount_paid" name="amount_paid" step="0.01" min="0" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="reference_number">Reference Number:</label>
                <input type="text" id="reference_number" name="reference_number" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="payment_datetime">Date and Time of Payment:</label>
                <input type="datetime-local" id="payment_datetime" name="payment_datetime" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="account_name">Account Name:</label>
                <input type="text" id="account_name" name="account_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="account_number">Account Number:</label>
                <input type="text" id="account_number" name="account_number" class="form-control" required>
            </div>
            </div>

            <button type="submit" class="checkout-btn">Submit Payment Details</button>
        </form>
    </main>

    <script>
        // Form validation
        const form = document.querySelector('.ticket-form');
        form.addEventListener('submit', function(e) {
            const amountPaid = parseFloat(document.getElementById('amount_paid').value);
            const referenceNumber = document.getElementById('reference_number').value.trim();
            const paymentDatetime = document.getElementById('payment_datetime').value;
            const accountName = document.getElementById('account_name').value.trim();
            const accountNumber = document.getElementById('account_number').value.trim();
            
            if (amountPaid <= 0) {
                e.preventDefault();
                alert('Please enter a valid amount paid');
                return false;
            }
            
            if (!referenceNumber) {
                e.preventDefault();
                alert('Please enter a reference number');
                return false;
            }
            
            if (!paymentDatetime) {
                e.preventDefault();
                alert('Please select payment date and time');
                return false;
            }
            
            if (!accountName) {
                e.preventDefault();
                alert('Please enter account name');
                return false;
            }
            
            if (!accountNumber) {
                e.preventDefault();
                alert('Please enter account number');
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>
