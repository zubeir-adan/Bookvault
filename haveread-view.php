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
            justify-content: flex-start;
        }
        .book {
            display: flex;
            align-items: center;
            width: 30%;
            margin: 0 1.5%;
            margin-bottom: 30px;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: #f9fafb;
            opacity: 100%;
        }
        .book img {
            width: 80px;
            height: auto;
            margin-right: 20px;
            border-radius: 4px;
        }
        .book-details {
            flex-grow: 1;
        }
        .book-title {
            font-size: 1.25rem; /* text-xl */
            font-weight: 700; /* font-bold */
            margin-bottom: 0.25rem; /* mb-1 */
        }
        .book-meta {
            font-size: 0.875rem; /* text-sm */
            color: #6b7280; /* text-gray-500 */
            margin-bottom: 1rem; /* mb-4 */
        }
        .fav-button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            font-weight: 500;
            color: #374151;
            background-color: #e5e7eb;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .fav-button:hover {
            background-color: #d1d5db;
        }
        .fav-button img {
            width: 24px; /* w-6 */
            height: 24px; /* h-6 */
            margin-right: 8px; /* mr-2 */
        }
        .message {
            padding: 10px;
            background-color: #d1e7dd; /* Nice shade of green */
            border: 1px solid #badbcc;
            color: #0f5132;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageBox = document.getElementById('message-box');
            if (messageBox) {
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</head>
<body>
<?php include("body/header2.php"); ?>

<div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold mt-8 mb-4">Books I've read</h2>

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
    include_once 'connection.php';

    if (isset($_SESSION['logging'])) {
        $userId = $_SESSION['user_id'];
        $sql = "SELECT * FROM `haveread` WHERE `user_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookImage = $row["book-img"];
                $bookTitle = $row["book-title"];
                $bookAuthors = $row["book-author"];
                $timestamp = $row["timestamp"];
                ?>
                <div class="book">
                    <img src="<?php echo htmlspecialchars($bookImage); ?>" alt="Book Cover">
                    <div class="book-details">
                        <h3 class="book-title"><?php echo htmlspecialchars($bookTitle); ?></h3>
                        <p class="book-meta">By <?php echo htmlspecialchars($bookAuthors); ?><br>Published Date: <?php echo htmlspecialchars($timestamp); ?></p>
                        <form action="favourite.php" method="post">
                            <input type="hidden" name="bookImage" value="<?php echo htmlspecialchars($bookImage); ?>">
                            <input type="hidden" name="bookTitle" value="<?php echo htmlspecialchars($bookTitle); ?>">
                            <input type="hidden" name="bookAuthor" value="<?php echo htmlspecialchars($bookAuthors); ?>">
                            <input type="hidden" name="bookDate" value="<?php echo htmlspecialchars($timestamp); ?>">

                            <button class="fav-button" type="submit" aria-label="Like" title="Add to favourites">
                                <img src="img/fav.png" alt="Add to fav"> Add to favourites
                            </button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="text-gray-600">No books added to read list yet.</p>';
        }

        $stmt->close();
        $conn->close();
    } else {
        echo '<p class="text-gray-600">User not logged in.</p>';
    }
    ?>
    </div>
</div>

<?php include("body/footer.php"); ?>
</body>
</html>
