<?php

session_start();


if(isset($_SESSION['logging']) && $_SESSION['logging'] === true){
  
    session_destroy();
    // Redirect the admin to the homepage (homepage.html)
    header("location: userlogin.html");
    exit();
} else {
   
    echo "You are not logged in.";
}
?>
