<?php
require_once("connection.php");

if(isset($_GET["id"])){
    $user_id = $_GET["id"];

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete from search_history first to avoid foreign key constraint issues
        $sql1 = "DELETE FROM search_history WHERE user_id ='$user_id'";
        if (!mysqli_query($conn, $sql1)) {
            throw new Exception("Error deleting from search_history: " . mysqli_error($conn));
        }

        // Delete from users
        $sql2 = "DELETE FROM users WHERE user_id ='$user_id'";
        if (!mysqli_query($conn, $sql2)) {
            throw new Exception("Error deleting from users: " . mysqli_error($conn));
        }

        // Commit transaction
        mysqli_commit($conn);

        header('location: adminloggedin.php');
        exit;
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);

        echo $e->getMessage();
    }
} else {
    echo "User ID not provided.";
}
?>
