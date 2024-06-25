<?php

include_once 'connection.php';
session_start();

if (isset($_SESSION['logging'])) {
    // Retrieve the user's ID from the session
    $userId = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bookImage = $_POST['bookImage'];
        $bookTitle = $_POST['bookTitle'];
        $bookAuthors = $_POST['bookAuthors'];
        $bookPublishedDate = $_POST['bookPublishedDate'];

        // Prepare SQL statement
        $sql = "INSERT INTO `want-to-read` (`book-img`, `book-title`, `book-author`, `book-date`, `user_id`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssssi", $bookImage, $bookTitle, $bookAuthors, $bookPublishedDate, $userId);

        // Execute statement
        if ($stmt->execute()) {
            header("Location: toread-view.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>
