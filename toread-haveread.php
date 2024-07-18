<?php
include_once 'connection.php';
session_start();

// Check if user is logged in and has the correct session
if (isset($_SESSION['logging']) && isset($_SESSION['user_id'])) {
    // Retrieve the user's ID from the session
    $userId = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bookId = $_POST['bookId'];
        $bookImage = $_POST['bookImage'];
        $bookTitle = $_POST['bookTitle'];
        $bookAuthors = $_POST['bookAuthors'];
        $bookPublishedDate = $_POST['bookPublishedDate'];

        
        // Move book from 'want-to-read' to 'have-read'
        $conn->begin_transaction();
        try {
            $sqlInsert = "INSERT INTO `haveread` (`book-img`, `book-title`, `book-author`, `book-date`, `user_id`) VALUES (?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("ssssi", $bookImage, $bookTitle, $bookAuthors, $bookPublishedDate, $userId);
            $stmtInsert->execute();
            
            $sqlDelete = "DELETE FROM `want-to-read` WHERE `id` = ? AND `user_id` = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("ii", $bookId, $userId);
            $stmtDelete->execute();
        

            $conn->commit();
            

            // Set session message
            $_SESSION['message'] = "Book has been added to Have Read category.";
        } catch (Exception $e) {
            $conn->rollback();
            // Handle exception
        }
      
        // Close statements
        $stmtInsert->close();
        $stmtDelete->close();

        // Redirect back to toread-view.php
        header("Location: toread-view.php");
        exit();
    }
} else {
    // Redirect user to login if not authenticated
    header("Location: userlogin.html");
    exit();
}

// Close database connection
$conn->close();
?>
