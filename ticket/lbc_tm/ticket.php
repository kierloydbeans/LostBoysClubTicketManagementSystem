<?php
require_once 'includes/session_manager.php';
require_once 'config/database.php';

// Require user to be logged in
requireLogin();

// Get current user info
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Boys Club - Dashboard</title>
    <link rel="stylesheet" href="styles.css">
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
            <a href="#" class="account-link">Account</a>
            <span class="user-info">Welcome, <?php echo htmlspecialchars($user['first_name']); ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="events-container">
        <div class="events-header">
            <h2>UPCOMING EVENTS</h2>
        </div>

        <div class="events-grid">
            <!-- Event Card 1 -->
            <div class="event-card">
                <div class="event-image">
                    <img src="images/logo.jpg" alt="LBC Event" class="event-logo">
                </div>
                <div class="event-info">
                    <h3 class="event-name">Event Name</h3>
                    <p class="event-datetime">Date and Time</p>
                    <a href="view_tickets.php?event_id=1" class="view-tickets-btn">View Tickets</a>                </div>
            </div>

            <!-- Event Card 2 -->
            <div class="event-card">
                <div class="event-image">
                    <img src="images/logo.jpg" alt="LBC Event" class="event-logo">
                </div>
                <div class="event-info">
                    <h3 class="event-name">Event Name</h3>
                    <p class="event-datetime">Date and Time</p>
                    <a href="view_tickets.php?event_id=1" class="view-tickets-btn">View Tickets</a>                </div>
            </div>

            <!-- Event Card 3 -->
            <div class="event-card">
                <div class="event-image">
                    <img src="images/logo.jpg" alt="LBC Event" class="event-logo">
                </div>
                <div class="event-info">
                    <h3 class="event-name">Event Name</h3>
                    <p class="event-datetime">Date and Time</p>
                    <a href="view_tickets.php?event_id=1" class="view-tickets-btn">View Tickets</a>                </div>
            </div>

            <!-- Event Card 4 -->
            <div class="event-card">
                <div class="event-image">
                    <img src="images/logo.jpg" alt="LBC Event" class="event-logo">
                </div>
                <div class="event-info">
                    <h3 class="event-name">Event Name</h3>
                    <p class="event-datetime">Date and Time</p>
                    <a href="view_tickets.php?event_id=1" class="view-tickets-btn">View Tickets</a>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Any additional JavaScript for the dashboard can go here
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard loaded');
        });
    </script>
</body>

</html>