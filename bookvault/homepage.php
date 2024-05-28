<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
.book {
    padding: 10px;
    border: 1px solid #ccc; 
}
.book img {
    width: 30%;
    height: auto; 
}

@media (max-width: 768px) {
    .book {
        width: calc(50% - 20px); 
    }
}
.book-container-fav {
    display: grid;
    grid-template-columns: repeat(3, minmax(200px, 1fr));
    gap: 20px;
    justify-items: start; /* Align items to the start */
}
.book-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); 
    gap: 20px;
    
}
.book-fav {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px; 
    display: inline-block; /* Add this line */
    width: 200px; /* Add this line */
    box-sizing: border-box; /* Add this line */
}

.book-read,
.book-want {
    border-radius: 20px;
    border-color: black; 
}
 </style>
</head>
<body>
<?php include("body/header.php"); ?>

<img src="img/vaultimg.png" alt="Book Vault" class="w-full h-auto" style="margin-top: -40px;">


<div class="max-w-xl mx-auto">
<h1 class="text-3xl font-bold mt-8 mb-4 text-center">My Book Collection</h1>


    <!-- Display Favorite Books -->

    <h3 class="text-2xl font-bold mt-8 mb-4 text-center">My Favorite Books</h3>
    <h3 class="text-2xl font-bold mt-8 mb-4"></h3>
    <div class="book-container-fav">
        <?php
       
        include_once 'connection.php';

       
        $sql = "SELECT id, book_img, book_title, book_author, book_date FROM favorite_books";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            while ($row = $result->fetch_assoc()) {
              
                ?>

<div class="book-fav">
    <div class="border p-4 rounded-lg">
        <div class="flex items-center mb-4">
            <img src="<?php echo $row["book_img"]; ?>" alt="Book Cover" class="w-16 h-auto mr-4">
            <div>
                <h3 class="text-lg font-semibold"><?php echo $row["book_title"]; ?></h3>
                <p class="text-sm text-gray-500">By: <?php echo $row["book_author"]; ?> </p>
            </div>
        </div>
    </div>
</div>
                <?php
            }
        } else {
            echo '<p class="text-gray-600">No favorite books added yet.</p>';
        }
        ?>
    </div>
</div>

    <!-- Display Books You Want to Read -->

    <h3 class="text-2xl font-bold mt-8 mb-4 text-center">Books I Want to Read</h3>
    <div class="book-container">
        <?php
       
        $sql = "SELECT * FROM `want-to-read`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          
            while ($row = $result->fetch_assoc()) {
                displayBook($row, 'book-want');
            }
        } else {
            echo '<p class="text-gray-600">No books added to read list yet.</p>';
        }
        ?>
    </div>

    <!-- Display Books You Have Read -->

    <h3 class="text-2xl font-bold mt-8 mb-4 text-center">Books I Have Read</h3>
    <div class="book-container">
        <?php
       
        $sql = "SELECT * FROM `haveread`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
         
            while ($row = $result->fetch_assoc()) {
                displayBook($row, 'book-read');
            }
        } else {
            echo '<p class="text-gray-600">No books added to your read list yet.</p>';
        }
        ?>
    </div>

</div>

<?php include("body/footer.php"); ?>

<?php
// Function to display book details
function displayBook($row, $bookClass) {
    // Check if any essential fields are empty
    if (!empty($row["book-img"]) && !empty($row["book-title"]) && !empty($row["book-author"]) && !empty($row["book-date"])) {
        echo '<div class="book ' . $bookClass . '">';
        echo '<div class="flex items-center mb-4">';
        echo '<img src="' . $row["book-img"] . '" alt="Book Cover" class="w-16 h-auto mr-4">';
        echo '<div>';
        echo '<h3 class="text-lg font-semibold">' . $row["book-title"] . '</h3>';
        echo '<p class="text-sm text-gray-500">By: ' . $row["book-author"] . ' <br> Date Published: ' . $row["book-date"] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>
</body>
</html>