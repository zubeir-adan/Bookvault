<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books I've read</title>
    <link rel="stylesheet" href="css/styler.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
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
<?php include("body/header2.php"); ?>

<div class="max-w-7xl mx-auto"> <!-- Changed max width for wider container -->
    <h2 class="text-3xl font-bold mt-8 mb-4">Books I've read</h2>
    <div class="book-container">
    <?php
    include_once 'connection.php';

    if (isset($_SESSION['logging'])) {
        // Retrieve the user's ID from the session
        $userId = $_SESSION['user_id'];

        // Prepare the SQL query to filter by user ID
        $sql = "SELECT * FROM `haveread` WHERE `user_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $bookImage = $row["book-img"];
                $bookTitle = $row["book-title"];
                $bookAuthors = $row["book-author"];
                $bookPublishedDate = $row["book-date"];
                $timestamp = $row["timestamp"]; // Get the timestamp from the database
                ?>
                <div class="book">
                    <div class="flex items-center">
                        <img src="<?php echo htmlspecialchars($bookImage); ?>" alt="Book Cover" class="w-16 h-auto mr-4">
                        <div>
                            <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($bookTitle); ?></h3>
                            <p class="text-sm text-gray-500">By <?php echo htmlspecialchars($bookAuthors); ?> <br> Published Date: <?php echo htmlspecialchars($bookPublishedDate); ?> <br> Book added on: <?php echo htmlspecialchars($timestamp); ?></p>
                        </div>
                    </div>
                    <!-- Favorite button -->
                    <form action="favourite.php" method="post">
                        <input type="hidden" name="bookImage" value="<?php echo htmlspecialchars($bookImage); ?>">
                        <input type="hidden" name="bookTitle" value="<?php echo htmlspecialchars($bookTitle); ?>">
                        <input type="hidden" name="bookAuthor" value="<?php echo htmlspecialchars($bookAuthors); ?>">
                        <input type="hidden" name="bookDate" value="<?php echo htmlspecialchars($bookPublishedDate); ?>">

                        <button class="flex-none flex items-center justify-center w-10 h-10 text-slate-300 ml-20 hover:text-red-800" type="submit" aria-label="Like" title="Add to favourites"> 
                            <svg width="20" height="20" aria-hidden="true" class="fill-current">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" fill="#4B5563" />
                            </svg>
                        </button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo '<p class="text-gray-600">No books added to read list yet.</p>';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo '<p class="text-gray-600">User not logged in.</p>';
    }
    ?>
    </div>
</div>
<div class="container">
    <form method="post" action="userlogout.php">
        <input type="submit" value="Logout" class="logout-button" style="background-color: #708ee6; color: white; border: none; border-radius: 5px; padding: 10px 20px; font-size: 16px; cursor: pointer;">
    </form>
</div>
<?php include("body/footer.php"); ?>
</body>
</html>
