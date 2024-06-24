<?php

include_once 'connection.php';

session_start();

if (isset($_SESSION['logging'])) {
    include_once 'connection.php';

    // Retrieve the user's ID from the session
    $userId = $_SESSION['user_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $bookImage = $_POST['bookImage'];
    $bookTitle = $_POST['bookTitle'];
    $bookAuthors = $_POST['bookAuthors'];
    $bookPublishedDate = $_POST['bookPublishedDate'];

    
    $sql = "INSERT INTO `want_to_ read` (`book_img`, `book_title`, `book_author`, `book_date`, `user_id`) VALUES (?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $bookImage, $bookTitle, $bookAuthors, $bookPublishedDate,$userId);

    if ($stmt->execute()) {
      
       header("Location: toread-view.php");
       exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

  
    $stmt->close();

    
    $conn->close(); 
    }
}

?>
