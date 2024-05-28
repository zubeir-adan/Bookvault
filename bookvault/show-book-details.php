<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<script>
    function submitFormAndRedirect(formId, redirectUrl) {
        document.getElementById(formId).submit(); 
        setTimeout(function() {
            window.location.href = redirectUrl;
        }, 500);
    }
</script>
<body>
<?php include("body/header.php"); ?>

<div class="flex font-serif max-w-xl mx-auto">
    <?php
    if(isset($_GET['bookId'])) {
        $bookId = $_GET['bookId'];

        // Fetch book details based on the bookId from the Google Books API
        $url = 'https://www.googleapis.com/books/v1/volumes/' . $bookId;
        $response = file_get_contents($url);
        $bookData = json_decode($response, true);

        // Display book details
        if($bookData) {
            $bookImage = isset($bookData['volumeInfo']['imageLinks']['thumbnail']) ? $bookData['volumeInfo']['imageLinks']['thumbnail'] : 'default_image_icon.jpg';
            $bookTitle = isset($bookData['volumeInfo']['title']) ? $bookData['volumeInfo']['title'] : 'Title Not Available';
            $bookAuthors = isset($bookData['volumeInfo']['authors']) ? implode(', ', $bookData['volumeInfo']['authors']) : 'Unknown';
            $bookPublishedDate = isset($bookData['volumeInfo']['publishedDate']) ? $bookData['volumeInfo']['publishedDate'] : 'Unknown';
            $bookDescription = isset($bookData['volumeInfo']['description']) ? $bookData['volumeInfo']['description'] : 'No description available';
    ?>
    <div class="flex-none relative w-52">
        <img src="<?php echo $bookImage; ?>" alt="Book Cover" class="absolute w-auto h-auto object-cover" loading="lazy" />
    </div>
    <div class="flex-auto p-6">
        <h1 class="mb-3 text-2xl leading-none text-slate-900"><?php echo $bookTitle; ?></h1>
        <div class="text-lg font-medium text-slate-500"><?php echo $bookAuthors; ?></div>
        <div class="text-xs leading-6 font-medium uppercase text-slate-500"><?php echo $bookPublishedDate; ?></div>
        <p class="text-sm text-slate-500"><?php echo $bookDescription; ?></p>
        <br><br>
        <div class="flex items-center space-x-4 mb-5 text-sm font-medium">
            <form id="wantToReadForm" action="toread-pass.php" method="post">
                <input type="hidden" name="bookImage" value="<?php echo htmlspecialchars($bookImage); ?>">
                <input type="hidden" name="bookTitle" value="<?php echo htmlspecialchars($bookTitle); ?>">
                <input type="hidden" name="bookAuthors" value="<?php echo htmlspecialchars($bookAuthors); ?>">
                <input type="hidden" name="bookPublishedDate" value="<?php echo htmlspecialchars($bookPublishedDate); ?>">
                <button onclick="submitFormAndRedirect('wantToReadForm', 'toread-view.php')" 
                    class="flex-none w-32 h-32 border border-blue-900 rounded-xl p-4 transform transition-transform duration-200 hover:scale-110" 
                    type="button">
                    <img src="img/wanttoread.png" alt="Want to read" class="mx-auto h-8 w-8" />
                    <div class="text-center font-bold">Want to read</div>
                </button>
            </form>

            <form id="haveReadForm" action="haveread-pass.php" method="post">
                <input type="hidden" name="bookImage" value="<?php echo htmlspecialchars($bookImage); ?>">
                <input type="hidden" name="bookTitle" value="<?php echo htmlspecialchars($bookTitle); ?>">
                <input type="hidden" name="bookAuthors" value="<?php echo htmlspecialchars($bookAuthors); ?>">
                <input type="hidden" name="bookPublishedDate" value="<?php echo htmlspecialchars($bookPublishedDate); ?>">
                <button onclick="submitFormAndRedirect('haveReadForm', 'haveread-view.php')" 
                    class="flex-none w-32 h-32 border border-green-500 rounded-xl p-4 transform transition-transform duration-200 hover:scale-110" 
                    type="button">
                    <img src="img/haveread.png" alt="Have read" class="mx-auto h-8 w-8" />
                    <div class="text-center font-bold">Have read</div>
                </button>
            </form>

            <form id="FavouriteForm" action="favourite.php" method="post">
                <input type="hidden" name="bookImage" value="<?php echo htmlspecialchars($bookImage); ?>">
                <input type="hidden" name="bookTitle" value="<?php echo htmlspecialchars($bookTitle); ?>">
                <input type="hidden" name="bookAuthors" value="<?php echo htmlspecialchars($bookAuthors); ?>">
                <input type="hidden" name="bookPublishedDate" value="<?php echo htmlspecialchars($bookPublishedDate); ?>">
                <button onclick="submitFormAndRedirect('FavouriteForm', 'favourite.php')" 
                    class="flex-none w-32 h-32 border border-red-500 rounded-xl p-4 transform transition-transform duration-200 hover:scale-110" 
                    type="button">
                    <img src="img/fav.png" alt="Favourite" class="mx-auto h-8 w-8" />
                    <div class="text-center font-bold">Favourite</div>
                </button>
            </form>
        </div>
    </div>
    <?php
        } else {
            echo '<p class="flex-auto p-6">Book details not found.</p>';
        }
    } else {
        echo '<p class="flex-auto p-6">No book selected.</p>';
    }
    ?>
</div>

<?php include("body/footer.php"); ?>
</body>
</html>
