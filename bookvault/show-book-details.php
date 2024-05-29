<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .star-rating {
            font-size: 1.5rem;
            color: #FFD700;
            margin-top: 10px;
        }
    </style>
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
          // Fetch book ratings from Open Library API
    $bookTitle = isset($bookData['volumeInfo']['title']) ? urlencode($bookData['volumeInfo']['title']) : '';
    $openLibraryUrl = "https://openlibrary.org/search.json?title={$bookTitle}";
    $openLibraryResponse = file_get_contents($openLibraryUrl);
    $openLibraryData = json_decode($openLibraryResponse, true);

    $ratingsCount = 0;
    $averageRating = 0;
    if ($openLibraryData && isset($openLibraryData['docs']) && count($openLibraryData['docs']) > 0) {
        // Iterate through the search results to find matching book and retrieve ratings
        foreach ($openLibraryData['docs'] as $book) {
            if (isset($book['title']) && strtolower($book['title']) === strtolower($bookData['volumeInfo']['title'])) {
                // If the title matches, retrieve ratings data
                $ratingsCount = isset($book['rating_count']) ? $book['rating_count'] : 0;
                $averageRating = isset($book['average_rating']) ? $book['average_rating'] : 0;
                break;
            }
        }
    }

  // Display book details
if ($bookData) {
    $bookImage = isset($bookData['volumeInfo']['imageLinks']['thumbnail']) ? $bookData['volumeInfo']['imageLinks']['thumbnail'] : 'img/default.jpg';
    $bookTitle = isset($bookData['volumeInfo']['title']) ? $bookData['volumeInfo']['title'] : 'Title Not Available';
    $bookAuthors = isset($bookData['volumeInfo']['authors']) ? implode(', ', $bookData['volumeInfo']['authors']) : 'Unknown';
    $bookPublishedDate = isset($bookData['volumeInfo']['publishedDate']) ? $bookData['volumeInfo']['publishedDate'] : 'Unknown';
    $bookDescription = isset($bookData['volumeInfo']['description']) ? $bookData['volumeInfo']['description'] : 'No description available';
    $bookRating = isset($bookData['volumeInfo']['averageRating']) ? $bookData['volumeInfo']['averageRating'] : null;
    $ratingsCount = isset($bookData['volumeInfo']['ratingsCount']) ? $bookData['volumeInfo']['ratingsCount'] : 'No ';
    $bookISBN = isset($bookData['volumeInfo']['industryIdentifiers'][0]['identifier']) ? $bookData['volumeInfo']['industryIdentifiers'][0]['identifier'] : 'ISBN Not Available';
    $bookPageCount = isset($bookData['volumeInfo']['pageCount']) ? $bookData['volumeInfo']['pageCount'] : 'Number of Pages Not Available';

    // Check if $bookRating is numeric
    if (is_numeric($bookRating)) {
        $starWidth = ($bookRating / 5) * 100;
    } else {
        // If $bookRating is not numeric, set starWidth to 0
        $starWidth = 0;
    }

    // Check if the image is the default one and add styles accordingly
    if ($bookImage === 'img/default.jpg') {
        $imageTag = '<img src="' . $bookImage . '" alt="Book Cover" style="width:100px;height:150px;" loading="lazy" />';
    } else {
        $imageTag = '<img src="' . $bookImage . '" alt="Book Cover" class="object-cover w-70% h-50% ml-[-40px]" loading="lazy" />';
    }
    ?>
    <div class="flex-none relative w-50">
        <?php echo $imageTag; ?>
        <div class="mt-3">
            <p class="text-sm text-slate-500"><b>Rating</b><br> 
                <span class="star-rating">
                    <?php 
                    $filledStars = floor($bookRating);
                    $emptyStars = 5 - $filledStars;
                    for ($i = 0; $i < $filledStars; $i++) {
                        echo '<i class="fas fa-star"></i>';
                    }
                    for ($i = 0; $i < $emptyStars; $i++) {
                        echo '<i class="far fa-star"></i>';
                    }
                    ?>
                </span> 
                <br>
                <?php echo $bookRating; ?>/5 stars <br> <?php echo $ratingsCount; ?> ratings
            </p>
        </div>
    </div>

    <div class="flex-auto p-6">
        <h1 class="mb-3 text-2xl leading-none text-slate-900"><?php echo $bookTitle; ?></h1>
        <div class="text-lg font-medium text-slate-500"><?php echo $bookAuthors; ?></div><br>
        <div class="text-xs leading-6 font-medium  text-slate-500">Publication Date : <?php echo $bookPublishedDate; ?></div><br>
        <p class="text-sm text-slate-500"><p>ISBN: <?php echo $bookISBN; ?></p><br>
        <p class="text-sm text-slate-500"><p>Number of Pages: <?php echo $bookPageCount; ?></p><br>
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
                <input type="hidden" name="bookImage" value="<?php echo htmlspecialchars ($bookImage); ?>">
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
            <input type="hidden" name="bookTitle" value="<?php echo htmlspecialchars ($bookTitle); ?>">
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
