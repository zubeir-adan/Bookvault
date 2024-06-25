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
    
    <!-- Include any additional stylesheets or meta tags -->
    <style>
        body {
            font-family: Arial, sans-serif; /* Example font family */
          
            margin: 0;
            padding: 0;
        }
        .main-content {
            max-width: 800px; /* Adjust max-width as needed */
            margin: auto; /* Center align content */
            padding: 20px;
          
        
        }
        .main-content h1 {
            font-size: 24px; /* Example heading font size */
            margin-bottom: 10px;
        }
        .main-content p {
            font-size: 16px; /* Example paragraph font size */
            color: #666; /* Example text color */
        }
    </style>
</head>
<body>
    <!-- Header content is now included from header2.php -->

    <div class="main-content">
        <h1>Analytics Page</h1>
        <p>This is your analytics view page content.</p>
        <!-- Replace with your actual analytics content -->

      
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
