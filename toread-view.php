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
        .have-read-button {
            border: 2px solid #cccccc; /* Light grey border */
            border-radius: 12px; /* Rounded corners */
            padding: 4px 8px; /* Padding for button */
            background-color: transparent; /* Transparent background */
            opacity: 0.8; /* Slightly reduced opacity */
            transition: background-color 0.3s ease, opacity 0.3s ease; /* Smooth transition */
        }
        .have-read-button:hover {
            background-color: #f5f5f5; /* Light smoke color on hover */
            opacity: 1; /* Full opacity on hover */
        }
        .message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageBox = document.getElementById('message-box');
            if (messageBox) {
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 4000);
            }
        });
    </script>
</head>
<body>
<div class="max-w-7xl mx-auto"> <!-- Changed max width for wider container -->
    <h2 class="text-3xl font-bold mt-8 mb-4">Books I want to read</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div id="message-box" class="message">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="book-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookId = $row["id"]; // Assuming there's a unique ID for each book entry
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
                            <p class="text-sm text-gray-500">By <?php echo htmlspecialchars($bookAuthors); ?></p>
                            <p class="text-sm text-gray-500">Published Date: <?php echo htmlspecialchars($bookPublishedDate); ?></p>
                            <form action="toread-haveread.php" method="post">
                                <input type="hidden" name="bookId" value="<?php echo $bookId; ?>">
                                <input type="hidden" name="bookImage" value="<?php echo htmlspecialchars($bookImage); ?>">
                                <input type="hidden" name="bookTitle" value="<?php echo htmlspecialchars($bookTitle); ?>">
                                <input type="hidden" name="bookAuthors" value="<?php echo htmlspecialchars($bookAuthors); ?>">
                                <input type="hidden" name="bookPublishedDate" value="<?php echo htmlspecialchars($bookPublishedDate); ?>">
                                <button type="submit" class="flex items-center mt-2 have-read-button">
                                    <img src="img/haveread.png" alt="Have Read" class="w-6 h-6 mr-2"> Have read
                                </button>
                            </form>
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
