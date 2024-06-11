<?php
session_start();

if (isset($_SESSION['logging'])) {
    include_once 'connection.php';

    // Retrieve the user's ID from the session
    $userId = $_SESSION['user_id'];
    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <style>
         body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    h3 {
      font-size: 20px;
      text-align: center;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    /* Remove underlines from links */
    a {
      text-decoration: none;
    }

    .welcome {
      position: absolute;
      top: 0;
      right: 0;
    }
      </style>
      <title>BookVault - Dashboard</title>
    </head>
    <body>
      <!-- Navigation Bar -->
      <header>
        <nav>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="search.php">Search</a></li>
            <li><a href="#">My Books</a></li>
            <li><a href="#">Profile</a></li>
          </ul>
        </nav>
      </header>

      <!-- Welcome Message -->
      <div class="container">
        <h3>Welcome, <?php echo $_SESSION["username"]; ?></h3>
      </div>

      <!-- Search Button -->
      <div class="container">
        <form method="get" action="search.php">
          <input type="submit" value="Search">
        </form>
      </div>
      
      <!-- Logout Button -->
      <div class="container" style="text-align: center; margin-top: 20px;">
        <form method="post" action="userlogout.php">
          <input type="submit" value="Logout" style="background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
        </form>
      </div>
    </body>
    </html>

    <?php
} else {
    header("Location: userlogin.html");
}
?>
