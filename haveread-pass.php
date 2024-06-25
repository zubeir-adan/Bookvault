<?php

include_once 'connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
    // Retrieve the user's ID from the session
    $userId = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize input data (optional, but recommended)
        $bookImage = filter_var($_POST['bookImage'], FILTER_SANITIZE_STRING);
        $bookTitle = filter_var($_POST['bookTitle'], FILTER_SANITIZE_STRING);
        $bookAuthors = filter_var($_POST['bookAuthors'], FILTER_SANITIZE_STRING);
        $bookPublishedDate = filter_var($_POST['bookPublishedDate'], FILTER_SANITIZE_STRING);

        // Prepare SQL statement
        $sql = "INSERT INTO `haveread` (`book-img`, `book-title`, `book-author`, `book-date`, `timestamp`, `user_id`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssssi", $bookImage, $bookTitle, $bookAuthors, $bookPublishedDate, $userId);

        // Execute statement
        if ($stmt->execute()) {
            header("Location: haveread-view.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    // Redirect to login page if user ID is not set in session
    header("Location: userlogin.html");
    exit();
}

?>
