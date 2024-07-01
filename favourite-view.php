<?php 
// Include header file (session_start() is not necessary here since it's already included in header2.php)
include_once 'body/header2.php';

// Check if user is logged in (you can directly use $_SESSION['user_id'] since it's set in header2.php)
if (!isset($_SESSION['user_id'])) {
    header("Location: userlogin.html");
    exit();
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Include database connection
include_once 'connection.php';

// Fetch favorite books specific to the logged-in user from the `favorite_books` table
$sql = "SELECT * FROM `favorite_books` WHERE `user_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favourite Books</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional CSS for styling book containers */
        .book-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* Space between books */
            gap: 20px; /* Gap between books */
        }
        .book {
            width: calc(25% - 20px); /* Adjusted width for 4 books per row with gap */
            margin-bottom: 20px;
            background-color: #f0f0f0; /* Just for visualization */
            padding: 10px; /* Just for visualization */
        }
        .book .book-image {
            text-align: center;
        }
        .book .book-image img {
            max-width: 80%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .book .book-title {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold mt-8 mb-4">My Favourite Books</h2>
    <div class="book-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookImage = $row["book-img"];
                $bookTitle = $row["book_title"];
                ?>
                <div class="book">
                    <div class="book-image">
                        <img src="<?php echo htmlspecialchars($bookImage); ?>" alt="Book Cover">
                    </div>
                    <div class="book-title">
                        <?php echo htmlspecialchars($bookTitle); ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="text-gray-600">No favorite books added yet.</p>';
        }
        // Close prepared statement and database connection
        $stmt->close();
        $conn->close();
        ?>
    </div>
</div>
 
<?php include("body/footer.php"); ?>
</body>
</html>
