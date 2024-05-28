<?php

include_once 'connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $bookImage = $_POST['bookImage'];
    $bookTitle = $_POST['bookTitle'];
    $bookAuthors = $_POST['bookAuthors'];
    $bookPublishedDate = $_POST['bookPublishedDate'];

    
    $sql = "INSERT INTO `want-to-read` (`book-img`, `book-title`, `book-author`, `book-date`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $bookImage, $bookTitle, $bookAuthors, $bookPublishedDate);

    if ($stmt->execute()) {
      
       header("Location: toread-view.php");
       exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

  
    $stmt->close();

    
    $conn->close();
}
?>
