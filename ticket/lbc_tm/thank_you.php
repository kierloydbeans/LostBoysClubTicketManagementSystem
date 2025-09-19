<?php
session_start();

// Get purchase details from URL
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;

// In a real application, you would fetch these details from the database
$event = [
    'title' => 'Event Title',
    'date' => 'October 15, 2023',
    'time' => '8:00 PM',
    'price' => 500, // This should match the price in ticket_purchase.php
    'order_number' => 'LBC-' . strtoupper(uniqid())
];

$total = $event['price'] * $quantity;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Purchase - Lost Boys Club</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .thank-you {
            max-width: 800px;
            margin: 4rem auto;
            padding: 2rem;
            text-align: center;
            background: rgba(26, 26, 46, 0.9);
            border-radius: 10px;
            color: #fff;
        }

        .thank-you h1 {
            color: #e94560;
            margin-bottom: 1rem;
        }

        .success-icon {
            font-size: 5rem;
            color: #4CAF50;
            margin: 1rem 0;
        }

        .order-summary {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 8px;
            margin: 2rem 0;
            text-align: left;
        }

        .order-summary h3 {
            color: #e94560;
            margin-top: 0;
            border-bottom: 1px solid #444;
            padding-bottom: 0.5rem;
        }

        .order-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1rem 0;
        }

        .order-details div {
            margin-bottom: 0.5rem;
        }

        .order-details strong {
            display: block;
            color: #e94560;
            margin-bottom: 0.25rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: #e94560;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 0.5rem;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #d13354;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #e94560;
            color: #e94560;
        }

        .btn-outline:hover {
            background: rgba(233, 69, 96, 0.1);
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
            <a href="ticket.php">Tickets</a>
            <a href="#09-" class="account-link">Account</a>
            <span class="user-info">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] ?? 'Guest'); ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </nav>
    </header>

    <main class="thank-you">
        <div class="success-icon">✓</div>
        <h1>Thank You for Your Purchase!</h1>
        <p>Your order has been received and is being processed. A confirmation email has been sent to your registered email address.</p>
        
        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="order-details">
                <div>
                    <strong>Order Number</strong>
                    <?php echo htmlspecialchars($event['order_number']); ?>
                </div>
                <div>
                    <strong>Order Date</strong>
                    <?php echo date('F j, Y'); ?>
                </div>
                <div>
                    <strong>Event</strong>
                    <?php echo htmlspecialchars($event['title']); ?>
                </div>
                <div>
                    <strong>Date & Time</strong>
                    <?php echo htmlspecialchars($event['date'] . ' at ' . $event['time']); ?>
                </div>
                <div>
                    <strong>Price per Ticket</strong>
                    ₱<?php echo number_format($event['price'], 2); ?>
                </div>
                <div>
                    <strong>Quantity</strong>
                    <?php echo $quantity; ?>
                </div>
                <div>
                    <strong>Price per Ticket</strong>
                    ₱<?php echo number_format($event['price'], 2); ?>
                </div>
                <div>
                    <strong>Total Amount</strong>
                    ₱<?php echo number_format($total, 2); ?>
                </div>
            </div>
        </div>

        <p>Your e-tickets will be sent to your email shortly. You can also download them from your account.</p>
        
        <div class="action-buttons">
            <a href="dashboard.php" class="btn">Back to Home</a>
            <a href="ticket.php" class="btn btn-outline">View My Tickets</a>
        </div>
    </main>
</body>
</html>
