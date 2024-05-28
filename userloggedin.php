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

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    

    th {
      background-color: #f2f2f2;
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

      <!-- My Books Section -->
      <h1>My book collection</h1>
      <div class="container">
        <h3>My Favorite Books</h3>
        <?php
        // Function to fetch books for a specific user from a specific table
        function fetchUserBooks($conn, $tableName, $userId) {
            $sql = "SELECT * FROM $tableName WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            return $stmt->get_result();
        }

        // Fetch and display favorite books
        $favoriteBooksResult = fetchUserBooks($conn, "favorite_books", $userId);
        if ($favoriteBooksResult->num_rows > 0) {
            while ($row = $favoriteBooksResult->fetch_assoc()) {
                echo "<div>";
                echo "<img src='" . $row["book_img"] . "' alt='Book Cover'>";
                echo "<p><strong>Title:</strong> " . $row["book_title"] . "</p>";
                echo "<p><strong>Author:</strong> " . $row["book_author"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No favorite books added yet.</p>";
        }
        ?>
      </div>

      <div class="container">
        <h3>Books I've Read</h3>
        <?php
        // Fetch and display books marked as haveread
        $havereadBooksResult = fetchUserBooks($conn, "haveread", $userId);
        if ($havereadBooksResult->num_rows > 0) {
            while ($row = $havereadBooksResult->fetch_assoc()) {
                echo "<div>";
                echo "<img src='" . $row["book-img"] . "' alt='Book Cover'>";
                echo "<p><strong>Title:</strong> " . $row["book-title"] . "</p>";
                echo "<p><strong>Author:</strong> " . $row["book-author"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No books marked as read yet.</p>";
        }
        ?>
      </div>

      <div class="container">
        <h3>Books I Want to Read</h3>
        <?php
        // Fetch and display books marked as want to read
        $wantToReadBooksResult = fetchUserBooks($conn, "want_to_read", $userId);
        if ($wantToReadBooksResult->num_rows > 0) {
            while ($row = $wantToReadBooksResult->fetch_assoc()) {
                echo "<div>";
                echo "<img src='" . $row["book-img"] . "' alt='Book Cover'>";
                echo "<p><strong>Title:</strong> " . $row["book-title"] . "</p>";
                echo "<p><strong>Author:</strong> " . $row["book-author"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No books marked as want to read yet.</p>";
        }
        ?>
      </div>

     
 <!-- Logout button (will have to be fixed to correct the ending of sessions)-->
 
 <a href="homepage.php" style="display: block; background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; position: relative; bottom: 0; left: 0;">Logout</a>

    </body>
    </html>

    <?php

} else {
    header("Location: userlogin.html");
}
?>
