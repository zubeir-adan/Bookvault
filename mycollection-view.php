<?php
// Include header file which might have session_start()
include_once 'body/header2.php';

// Check if session is active (not needed if session_start() is in header2.php)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: userlogin.html");
    exit();
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Include database connection
include_once 'connection.php';

// Function to fetch books from a specified table
function fetchBooks($conn, $userId, $tableName) {
    $sql = "SELECT * FROM `$tableName` WHERE `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $books = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    return $books;
}

// Fetch books from favorite_books table
$favoriteBooks = fetchBooks($conn, $userId, 'favorite_books');

// Fetch books from haveread table
$haveReadBooks = fetchBooks($conn, $userId, 'haveread');

// Fetch books from want_to_read table
$wantToReadBooks = fetchBooks($conn, $userId, 'want-to-read');

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Collection</title>
   
    <!-- Additional stylesheets or meta tags -->
    <style>
        /* Additional CSS specific to this page */
        .container {
            max-width: 1000px; /* Increased width */
            margin: 0 auto;
            padding: 20px;
        }
        .collection-section {
            margin-bottom: 30px;
        }
        .collection-section h2 {
            margin-bottom: 10px;
        }
        .collection-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .collection-item img {
            width: 50px; /* Adjust image width as needed */
            height: auto;
        }
        .collection-item .details {
            flex: 1;
            margin-left: 20px; /* Adjust spacing between image and details */
        }
        .book-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* Adjust to 5 columns */
            gap: 50px; /* Adjust gap between grid items */
        }
        .book {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
            position: relative;
        }
        .details h3 {
            font-weight: normal; /* Remove bold from book title */
        }
        .logout-button {
            background-color: #708ee6;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .logout-button:hover{
            background-color: #5c76c7;
        }
        .delete-button:hover {
            background-color: red;
        }
        .delete-button {
            background-color: cornsilk;
            color: ash;
            border: 2px;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .delete-button {
            position: absolute;
            bottom: 0px;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 20px; /* Adjusted padding to increase width */
            font-size: 15px;
            width: 100px; /* Adjust the width as needed */
            margin-bottom: -10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Collection</h1>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! Here's your collection:</p>

        <!-- Books I Want to Read Section -->
        <div class="collection-section">
            <h2>Books I Want to Read</h2>
            <?php if (!empty($wantToReadBooks)): ?>
                <div class="book-grid">
                    <?php foreach ($wantToReadBooks as $book): ?>
                        <div class="book">
                            <img src="<?php echo htmlspecialchars($book['book-img']); ?>" alt="Book Cover">
                            <div class="details">
                                <h3><?php echo htmlspecialchars($book['book-title']); ?></h3>
                            </div>
                            <form method="post" action="deletebookuser.php">
                                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                <input type="hidden" name="book_name" value="<?php echo htmlspecialchars($book['book-title']); ?>">
                                <input type="hidden" name="category" value="Want to Read">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No books added to 'Want to Read' list yet.</p>
            <?php endif; ?>
        </div>

        <!-- Books I Have Read Section -->
        <div class="collection-section">
            <h2>Books I Have Read</h2>
            <?php if (!empty($haveReadBooks)): ?>
                <div class="book-grid">
                    <?php foreach ($haveReadBooks as $book): ?>
                        <div class="book">
                            <img src="<?php echo htmlspecialchars($book['book-img']); ?>" alt="Book Cover">
                            <div class="details">
                                <h3><?php echo htmlspecialchars($book['book-title']); ?></h3>
                            </div>
                            <form method="post" action="deletebookuser.php">
                                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                <input type="hidden" name="book_name" value="<?php echo htmlspecialchars($book['book-title']); ?>">
                                <input type="hidden" name="category" value="Have Read">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No books recorded as 'Have Read' yet.</p>
            <?php endif; ?>
        </div>

        <!-- My Favorite Books Section -->
        <div class="collection-section">
            <h2>My Favorite Books</h2>
            <?php if (!empty($favoriteBooks)): ?>
                <div class="book-grid">
                    <?php foreach ($favoriteBooks as $book): ?>
                        <div class="book">
                            <img src="<?php echo htmlspecialchars($book['book-img']); ?>" alt="Book Cover">
                            <div class="details">
                                <h3><?php echo htmlspecialchars($book['book_title']); ?></h3>
                            </div>
                            <form method="post" action="deletebookuser.php">
                                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                <input type="hidden" name="book_name" value="<?php echo htmlspecialchars($book['book_title']); ?>">
                                <input type="hidden" name="category" value="Favorite">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No favorite books added yet.</p>
            <?php endif; ?>
        </div>
    </div>
   
    <?php include_once 'body/footer.php'; ?> <!-- Include footer -->
</body>
</html>
