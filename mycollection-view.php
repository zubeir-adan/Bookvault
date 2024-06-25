<?php


// Include header file
include_once 'body/header2.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Collection</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Adjust path as needed -->
    <!-- Additional stylesheets or meta tags -->
    <style>
        /* Additional CSS specific to this page */
        .collection-section {
            margin-bottom: 30px;
        }
        .collection-section h2 {
            margin-bottom: 10px;
        }
        .collection-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .collection-item img {
            width: 100px; /* Adjust image width as needed */
            height: auto;
        }
        .collection-item .details {
            flex: 1;
            margin-left: 20px; /* Adjust spacing between image and details */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Collection</h1>
        <p>Hello, <?php echo htmlspecialchars($username); ?>! Here's your collection:</p>

        <!-- Books I Want to Read Section -->
      
            <h2>Books I Want to Read</h2>

            <br><br>
           
                </div>
                <!-- Repeat for more items -->
            </div>
        </div>

        <!-- Books I Have Read Section -->
      
            <h2>Books I Have Read</h2>
            <br><br>

        <!-- My Favorite Books Section -->
     
            <h2>My Favorite Books</h2>
            <br><br>
    </div>
    <div class="container"> <form method="post" action="userlogout.php"> <input type="submit" value="Logout" class="logout-button" style="background-color: #708ee6; color: white; border: none; border-radius: 5px; padding: 10px 20px; font-size: 16px; cursor: pointer;"> </form> </div>

    <?php include_once 'body/footer.php'; ?> <!-- Include footer -->
</body>
</html>
