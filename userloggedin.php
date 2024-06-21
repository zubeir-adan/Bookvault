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
    .header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 20px;
            background-color: #f1f1f1;
            border-bottom: 2px solid #ddd;
            height: 70px;
        }
        .logo {
            height: 65px;
            margin-top: -20px;
        }
        .menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .menu li {
            display: inline;
        }
        .menu a {
            text-decoration: none;
            color: black;
            padding: 10px;
        }
        .header-buttons {
            display: flex;
            gap: 10px;
        }
        .header-buttons button {
            background-color: #808080;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .header-buttons button:hover {
            background-color: #45a049;
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
    .ul {
      display: flex;
    }

    .welcome {
      position: absolute;
      top: 0;
      right: 0;
    }
    .toread{
      margin top: 10px;
    }
    .li .suggest{
      text-align: center;
      margin-right: 200px;
    }
    /* styles.css */
body {
  margin: 0;
  font-family: Arial, sans-serif;
}

.header {
  display: flex;
  justify-content: center; /* Center the content horizontally */
  align-items: center; /* Center the content vertically */
  height: 100px;
  background-color: #f8f9fa;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.nav {
  flex: 1; /* Allow the nav to grow and take available space */
}

.nav-list {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
  width: 100%;
  justify-content: space-between; /* Distribute space between items */
  align-items: center; /* Center items vertically */
}

.nav-list li a {
  text-decoration: none;
  color: #333;
  padding: 10px 15px;
  background-color: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.nav-list li a:hover {
  background-color: #007bff;
  color: white;
}

.center-item {
  flex: 1; /* Allow the centered item to take available space */
  text-align: center;
}

      </style>
      <title>BookVault - Dashboard</title>
    </head>
    <body>
    <?php include("body/header.php"); ?>
      <!-- Welcome Message -->
      <div class="container">
        <h3>Welcome, <?php echo $_SESSION["username"]; ?></h3>
      </div>

      <!-- Search Button -->
     
      
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
