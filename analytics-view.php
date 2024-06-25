<?php

// Include the header2.php file from the body folder
include_once 'body/header2.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!-- Include any additional stylesheets or meta tags -->
</head>
<body>
    <!-- Header content is now included from header2.php -->

    <div class="main-content">
        <h1>Analytics Page</h1>
        <p>This is your analytics view page content.</p>
        <!-- Replace with your actual analytics content -->

        <p>Welcome, <?php echo $username; ?></p>
        <!-- Display username or user information as needed -->

    </div>

    <!-- Include any necessary JavaScript scripts -->
    <div class="container">
    <form method="post" action="userlogout.php">
        <input type="submit" value="Logout" class="logout-button" style="background-color: #708ee6; color: white; border: none; border-radius: 5px; padding: 10px 20px; font-size: 16px; cursor: pointer;text-align:center;">
    </form>
</div>


    <?php
    // Include the footer.php if required
     include("body/footer.php");
    ?>
</body>
</html>
