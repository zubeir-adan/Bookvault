<?php
session_start();

if (!isset($_SESSION['logging']) || $_SESSION['logging'] !== true) {
    header("location: adminlogin.php");
    exit();
}

include_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"]) && isset($_POST["book_name"]) && isset($_POST["category"])) {
    $user_id = $_POST["user_id"];
    $book_name = $_POST["book_name"];
    $category = $_POST["category"];

    // Determine the table and column based on the category
    $table = '';
    $column = '';
    if ($category == 'Favorite') {
        $table = 'favorite_books';
        $column = 'book_title';
    } else if ($category == 'Have Read') {
        $table = 'haveread';
        $column = '`book-title`';
    } else if ($category == 'Want to Read') {
        $table = '`want-to-read`';
        $column = '`book-title`';
    }

    // SQL query to delete the book from the determined table
    $sql = "DELETE FROM $table WHERE user_id = ? AND $column = ?";

    // Prepare and execute the SQL query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $book_name);

    if ($stmt->execute()) {
        echo "Book deleted successfully";
        header("Location: adminloggedin.php");
        exit();
    } else {
        echo "Error deleting book: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
