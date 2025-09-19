<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lost Boys Club Login</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <?php
  session_start();
  $error_message = $_SESSION['login_error'] ?? '';
  $logout_message = $_SESSION['logout_message'] ?? '';
  unset($_SESSION['login_error'], $_SESSION['logout_message']);
  ?>

  <!-- Navbar -->
  <header class="navbar">
    <div class="logo">
      <h1>Lost Boys Club</h1>
    </div>
    <nav class="nav-links">
      <a href="#">Home</a>
      <a href="#">Tickets</a>
      <a href="#">Account</a>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="main-container">
    <div class="login-card">
      <img src="images/logo.jpg" alt="Lost Boys Club Logo" class="login-logo">
      <h2>Login to your Account</h2>

      <?php if (!empty($error_message)): ?>
        <div class="alert alert-error">
          <?php echo htmlspecialchars($error_message); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($logout_message)): ?>
        <div class="alert alert-success">
          <?php echo htmlspecialchars($logout_message); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <label for="username">Username or Email</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit" class="login-btn">Enter</button>
      </form>
      <p class="signup-text">
        Don't have an account? <a href="#">Sign Up</a>
      </p>
    </div>
  </main>

</body>

</html>