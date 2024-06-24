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


    $sql = "INSERT INTO `haveread` (`book_img`, `book_title`, `book_author`, `book_date`, `timestamp`, `user_id`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $bookImage, $bookTitle, $bookAuthors, $bookPublishedDate,$userId);

    if ($stmt->execute()) {
      
       header("Location: haveread-view.php");
       exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

   
    $stmt->close();

    
    $conn->close();
}
}
?>
