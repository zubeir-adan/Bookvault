<?php
session_start();

// Redirect to login if not logged in as admin
if (!isset($_SESSION['logging']) || $_SESSION['logging'] !== true) {
    header("location: adminlogin.php");
    exit();
}

include_once 'connection.php';

// Pagination variables
$rowsPerPage = 10; // Number of rows per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$start = ($page - 1) * $rowsPerPage; // Starting row for query

// Updated SQL query to count total rows
$sqlCount = "SELECT COUNT(*) AS count FROM (
    SELECT users.user_id
    FROM users 
    JOIN favorite_books ON users.user_id = favorite_books.user_id
    UNION ALL
    SELECT users.user_id
    FROM users 
    JOIN haveread ON users.user_id = haveread.user_id
    UNION ALL
    SELECT users.user_id
    FROM users 
    JOIN `want-to-read` ON users.user_id = `want-to-read`.user_id
) AS user_count";

$resultCount = $conn->query($sqlCount);
$row = $resultCount->fetch_assoc();
$totalRows = $row['count'];

$totalPages = ceil($totalRows / $rowsPerPage);

// SQL query to fetch data with pagination
$sql = "
    SELECT users.user_id, users.username, favorite_books.book_title AS book_name, 'Favorite' AS category 
    FROM users 
    JOIN favorite_books ON users.user_id = favorite_books.user_id
    UNION ALL
    SELECT users.user_id, users.username, haveread.`book-title` AS book_name, 'Have Read' AS category 
    FROM users 
    JOIN haveread ON users.user_id = haveread.user_id
    UNION ALL
    SELECT users.user_id, users.username, `want-to-read`.`book-title` AS book_name, 'Want to Read' AS category 
    FROM users 
    JOIN `want-to-read` ON users.user_id = `want-to-read`.user_id
    LIMIT $start, $rowsPerPage";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User List</title>
        <style>
            /* Pagination styles */
            .pagination {
                margin: 20px 0;
                text-align: center;
            }

            .pagination a {
                margin: 0 5px;
                padding: 8px 12px; /* Increase padding for larger clickable area */
                text-decoration: none;
                border: 1px solid #007bff; /* Border color for buttons */
                border-radius: 4px;
                color: #007bff; /* Text color */
                transition: all 0.3s ease; /* Smooth transition effect */
                font-size: 14px; /* Font size */
                line-height: 1.5; /* Ensure consistent line height */
            }

            .pagination a:hover {
                background-color: #007bff; /* Background color on hover */
                color: #fff; /* Text color on hover */
                transform: scale(1.1); /* Enlarge slightly on hover */
            }

            .pagination a.active {
                background-color: #007bff; /* Active background color */
                color: #fff; /* Active text color */
            }
        </style>
    </head>
    <body>';

    echo '<table border="1" cellspacing="0" cellpadding="10" style="width: 90%;">
            <tr>
                <th>#</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Book Name</th>
                <th>Category</th>
                <th>Action</th>
            </tr>';

    // Initialize a counter for sequential numbering
    $counter = ($page - 1) * $rowsPerPage + 1;

    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $counter . '</td>
                <td>' . htmlspecialchars($row['user_id']) . '</td>
                <td>' . htmlspecialchars($row['username']) . '</td>
                <td>' . htmlspecialchars($row['book_name']) . '</td>
                <td>' . htmlspecialchars($row['category']) . '</td>
                <td>
                    <form action="deletebook.php" method="post" onsubmit="return confirm(\'Are you sure you want to delete?\')">
                        <input type="hidden" name="user_id" value="' . htmlspecialchars($row['user_id']) . '">
                        <input type="hidden" name="book_name" value="' . htmlspecialchars($row['book_name']) . '">
                        <input type="hidden" name="category" value="' . htmlspecialchars($row['category']) . '">
                        <button style="color: black; background-color: #e82727; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s, color 0.3s;" type="submit">DELETE</button>
                    </form>
                </td>
              </tr>';
        $counter++;
    }

    echo '</table>';

    // Pagination controls
    echo '<div class="pagination">';
    if ($page > 1) {
        echo '<a href="#" onclick="loadEditUserList(' . ($page - 1) . '); return false;">Previous</a>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo '<a href="#" class="active" onclick="return false;">' . $i . '</a>';
        } else {
            echo '<a href="#" onclick="loadEditUserList(' . $i . '); return false;">' . $i . '</a>';
        }
    }

    if ($page < $totalPages) {
        echo '<a href="#" onclick="loadEditUserList(' . ($page + 1) . '); return false;">Next</a>';
    }

    echo '</div>';

    echo '</body>
    </html>';
} else {
    echo "No users found.";
}

$conn->close();
?>
