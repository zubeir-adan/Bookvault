<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorite Books</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .book-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .book {
            width: 48%; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>

<?php include("body/header2.php"); ?> <!-- Include header -->

<div class="max-w-xl mx-auto">
    <h2 class="text-3xl font-bold mt-8 mb-4">My Favorite Books</h2>
    <div class="book-container">
        <?php
        // Include database connection file
        include_once 'connection.php';

        // SQL query to fetch favorite books data
        $sql = "SELECT * FROM `favorite_books`";
        $result = $conn->query($sql);

        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $bookImage = $row["book_img"]; 
                $bookTitle = $row["book_title"]; 
                $bookAuthors = $row["book_author"];
                $bookPublishedDate = $row["book_date"];

                // Display book details
                ?>
                <div class="book">
                    <div class="flex items-center mb-4">
                        <img src="<?php echo $bookImage; ?>" alt="Book Cover" class="w-16 h-auto mr-4">
                        <div>
                            <h3 class="text-lg font-semibold"><?php echo $bookTitle; ?></h3>
                            <p class="text-sm text-gray-500">By <?php echo $bookAuthors; ?> | Published Date: <?php echo $bookPublishedDate; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            // Display message if no favorite books found
            echo '<p class="text-gray-600">No favorite books added yet.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</div>
<div class="container"> <form method="post" action="userlogout.php"> <input type="submit" value="Logout" class="logout-button" style="background-color: #708ee6; color: white; border: none; border-radius: 5px; padding: 10px 20px; font-size: 16px; cursor: pointer;"> </form> </div>

<?php include("body/footer.php"); ?> <!-- Include footer -->

</body>
</html>
