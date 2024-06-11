<?php
require_once("connection.php");

if(isset ($_GET["id"])){
    $user_id = $_GET["id"];

    require_once("connection.php");

    $sql = "DELETE FROM users WHERE user_id ='$user_id' ";

    if (mysqli_query($conn, $sql)) {
        header('location: adminloggedin.php');
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "User ID not provided.";
}
?>
