<?php
session_start();

if (!isset($_SESSION['logging']) || $_SESSION['logging'] !== true) {
    header("location: adminlogin.php");
    exit();
}

include_once 'connection.php';

$sql = "
    SELECT users.user_id, users.username, favorite_books.book_title AS book_name, 'Favorite' AS category 
    FROM users 
    JOIN favorite_books ON users.user_id = favorite_books.user_id
    UNION
    SELECT users.user_id, users.username, haveread.`book-title` AS book_name, 'Have Read' AS category 
    FROM users 
    JOIN haveread ON users.user_id = haveread.user_id
    UNION
    SELECT users.user_id, users.username, `want-to-read`.`book-title` AS book_name, 'Want to Read' AS category 
    FROM users 
    JOIN `want-to-read` ON users.user_id = `want-to-read`.user_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table border="1" cellspacing="0" cellpadding="10" style="width: 100%;">';
    echo '<tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Book Name</th>
            <th>Category</th>
            <th>Action</th>
          </tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row['user_id']) . '</td>
                <td>' . htmlspecialchars($row['username']) . '</td>
                <td>' . htmlspecialchars($row['book_name']) . '</td>
                <td>' . htmlspecialchars($row['category']) . '</td>
                <td><button onclick="deleteBook(' . htmlspecialchars($row['user_id']) . ', \'' . htmlspecialchars($row['book_name']) . '\', \'' . htmlspecialchars($row['category']) . '\')">DELETE</button></td>
              </tr>';
    }
    echo '</table>';
} else {
    echo "No users found.";
}

$conn->close();
?>
