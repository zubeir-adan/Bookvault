<?php
include_once 'connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    // Retrieve the user's ID from the session
    $userId = $_SESSION['user_id'];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize input data (optional, but recommended)
        $bookImage = filter_var($_POST['bookImage'], FILTER_SANITIZE_STRING);
        $bookTitle = filter_var($_POST['bookTitle'], FILTER_SANITIZE_STRING);
       

        // Check if the book already exists in the favorites
        $sql_check = "SELECT * FROM `favorite_books` WHERE `book_title` = ? ";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $bookTitle);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "This book is already in your favorites.";
        } else {
            // Prepare SQL statement to insert the book into favorites
            $sql_insert = "INSERT INTO `favorite_books` (`book-img`, `book_title`, `user_id`) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssi", $bookImage, $bookTitle, $userId);

            // Execute the insert statement
            if ($stmt_insert->execute()) {
                header("Location: favourite-view.php");
                exit();
            } else {
                echo "Error: " . $stmt_insert->error;
            }

            // Close the insert statement
            $stmt_insert->close();
        }

        // Close the check statement
        $stmt_check->close();
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to login page if user ID is not set in session
    header("Location: userlogin.html");
    exit();
}
?>
