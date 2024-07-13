<?php
include_once 'connection.php';
session_start();

if (isset($_SESSION['logging']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bookImage = $_POST['bookImage'];
        $bookTitle = $_POST['bookTitle'];

        // Check if the book already exists in the user's favorite list
        $sqlCheck = "SELECT * FROM `favorite_books` WHERE `user_id` = ? AND `book_title` = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("is", $userId, $bookTitle);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            // Book already exists in the favorites list
            $_SESSION['message'] = "This book is already in your Favorites.";
        } else {
            // Check if the book exists in the 'have read' list
            $sqlHaveReadCheck = "SELECT * FROM `haveread` WHERE `user_id` = ? AND `book-title` = ?";
            $stmtHaveReadCheck = $conn->prepare($sqlHaveReadCheck);
            $stmtHaveReadCheck->bind_param("is", $userId, $bookTitle);
            $stmtHaveReadCheck->execute();
            $resultHaveReadCheck = $stmtHaveReadCheck->get_result();

            // Insert the book into the favorites list
            $sqlInsert = "INSERT INTO `favorite_books` (`book-img`, `book_title`, `user_id`, `timestamp`) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("ssi", $bookImage, $bookTitle, $userId);

            if ($stmtInsert->execute()) {
                if ($resultHaveReadCheck->num_rows > 0) {
                    $_SESSION['message'] = "Book has been added to Favorites.";
                } else {
                    $_SESSION['message'] = null; // No message if the book is not in 'have read'
                }
            } else {
                $_SESSION['message'] = "Error adding book to Favorites.";
            }

            $stmtInsert->close();
            $stmtHaveReadCheck->close();
        }

        $stmtCheck->close();
        header("Location: favourite-view.php");
        exit();
    }
} else {
    header("Location: userlogin.html");
    exit();
}

$conn->close();
?>
