<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books to Read</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional CSS for styling book containers */
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
<?php include("body/header.php"); ?>

<div class="max-w-xl mx-auto">
    <h2 class="text-3xl font-bold mt-8 mb-4">Books I want to read</h2>
    <div class="book-container">
        <?php
      
        include('connection.php');

       
        $sql = "SELECT * FROM `want-to-read`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {
                $bookImage = $row["book-img"];
                $bookTitle = $row["book-title"];
                $bookAuthors = $row["book-author"];
                $bookPublishedDate = $row["book-date"];
                ?>
                <div class="book">
                    <div class="flex items-center">
                        <img src="<?php echo $bookImage; ?>" alt="Book Cover" class="w-16 h-auto mr-4">
                        <div>
                            <h3 class="text-lg font-semibold"><?php echo $bookTitle; ?></h3>
                            <p class="text-sm text-gray-500">By <?php echo $bookAuthors; ?> <br> Published Date: <?php echo $bookPublishedDate; ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="text-gray-600">No books added to read list yet.</p>';
        }

       
        $conn->close();
        ?>
    </div>
</div>

<?php include("body/footer.php"); ?>
</body>
</html>
