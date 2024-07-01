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

// Fetch books specific to the logged-in user from the `want-to-read` table
$sql = "SELECT * FROM `want-to-read` WHERE `user_id` = ?";
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
    <title>Books I Want to Read</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional CSS for styling book containers */
        .book-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start; /* Changed from space-between to flex-start */
        }
        .book {
            width: 30%; 
            margin: 0 1.5%; /* Added horizontal margin for spacing */
            margin-bottom: 30px; 
        }
    </style>
</head>
<body>
<div class="max-w-7xl mx-auto"> <!-- Changed max width for wider container -->
    <h2 class="text-3xl font-bold mt-8 mb-4">Books I want to read</h2>
    <div class="book-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookImage = $row["book-img"];
                $bookTitle = $row["book-title"];
                $bookAuthors = $row["book-author"];
                $bookPublishedDate = $row["book-date"];
                ?>
                <div class="book">
                    <div class="flex items-center">
                        <img src="<?php echo htmlspecialchars($bookImage); ?>" alt="Book Cover" class="w-16 h-auto mr-4">
                        <div>
                            <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($bookTitle); ?></h3>
                            <p class="text-sm text-gray-500">By <?php echo htmlspecialchars($bookAuthors); ?> <br> Published Date: <?php echo htmlspecialchars($bookPublishedDate); ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="text-gray-600">No books added to read list yet.</p>';
        }

        // Close prepared statement and database connection
        $stmt->close();
        $conn->close();
        ?>
    </div>
</div>


<?php include("body/footer.php"); ?> <!-- Include footer -->
</body>
</html>
