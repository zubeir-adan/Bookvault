<?php
// discover.php

// Genres to search for
$genres = [
    'action and adventure', 'art', 'arts and crafts', 'autobiography', 'biography',
    'business and finance', 'children', 'cooking', 'comic books', 'crafts and hobbies',
    'crime', 'drama', 'education', 'encyclopedia', 'fashion',
    'fantasy', 'food and cooking', 'gardening', 'graphic novels', 'health and fitness',
    'historical', 'history', 'home improvement', 'horror', 'humor',
    'junior fiction', 'languages', 'law', 'magazines', 'mathematics',
    'medical', 'music', 'mystery', 'nature', 'newspapers',
    'parenting', 'philosophy', 'photography', 'plays', 'poetry',
    'politics', 'reference', 'religion and spirituality', 'romance', 'science',
    'science fiction', 'screenplays', 'self help', 'short stories', 'social sciences',
    'sports', 'spirituality', 'suspense', 'technology', 'thriller',
    'transportation', 'travel', 'true crime', 'trivia', 'westerns',
    'wildlife', 'young '
];

// Sort genres alphabetically
sort($genres);

// Function to fetch books by genre from Google Books API
function fetchBooksByGenre($genre) {
    $url = 'https://www.googleapis.com/books/v1/volumes?q=subject:' . urlencode($genre);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Pagination settings
$genresPerPage = 5;
$totalGenres = count($genres);
$totalPages = ceil($totalGenres / $genresPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
} elseif ($page > $totalPages) {
    $page = $totalPages;
}
$startIndex = ($page - 1) * $genresPerPage;
$currentGenres = array_slice($genres, $startIndex, $genresPerPage);

// Check if a specific genre is requested
$requestedGenre = isset($_GET['genre']) ? strtolower($_GET['genre']) : '';

// Find the page where the requested genre is located
if (!empty($requestedGenre)) {
    $genreIndex = array_search($requestedGenre, array_map('strtolower', $genres));
    if ($genreIndex !== false) {
        $page = ceil(($genreIndex + 1) / $genresPerPage);
        $startIndex = ($page - 1) * $genresPerPage;
        $currentGenres = array_slice($genres, $startIndex, $genresPerPage);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            position: sticky;
            top: 0;
            background: #f7f7f8;
            border-bottom: 3px solid #87CEEB;
            z-index: 1000;
        }

        .header .nav li a {
            color: lightslategrey;
            display: block;
            line-height: 30px;
            padding: 2px 0 0;
            width: 100px;
            background: url('../img/book-vault-logo.png') no-repeat 0px 60px;
            white-space: nowrap;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            text-decoration: none;
            cursor: pointer;
        }

        /* Genre container styles */
        .genre-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0px 0;
            position: relative;
            border: 1px solid black;
            padding: 10px;
            background-color: skyblue;
        }

        .genre-list {
            display: flex;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            width: calc(90% - 60px);
            padding: 10px;
            background-color: skyblue;
        }

        .genre-item {
            margin: 0 10px;
            padding: 5px 10px;
            color: black;
            cursor: pointer;
            text-decoration: none; /* Remove underline */
            transition: color 0.3s ease; /* Smooth color transition */
        }

        .genre-item:hover {
            color: yellow; /* Change text color on hover */
        }

        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: white;
            border: 1px solid black;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000; /* Ensure arrows are above other content */
        }

        .arrow.left {
            left: 10px; /* Adjust position from the left */
        }

        .arrow.right {
            right: 10px; /* Adjust position from the right */
        }

        /* Section and carousel styles */
        .genre-section {
            margin-bottom: 40px;
        }

        .genre-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .carousel {
            display: flex;
            overflow-x: scroll;
            overflow-y: hidden;
            position: relative;
            width: 100%;
        }

        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease;
        }

        .book {
            flex: 0 0 200px;
            margin: 10px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .book img {
            width: 150px;
            height: 200px;
            border: 1px solid #ccc;
            padding: 5px;
            background-color: #fff;
        }

        .book-title {
            margin-top: 10px;
            word-wrap: break-word;
        }

        .book:hover {
            transform: scale(1.05);
        }

        /* Pagination styles */
        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            display: inline-block;
            padding: 10px 15px;
            margin: 0 5px;
            background-color: #f7f7f8;
            color: #333;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #87CEEB;
        }

        .pagination a.active {
            background-color: #87CEEB;
            color: #fff;
        }

        /* Scrollbar styles */
        ::-webkit-scrollbar {
            width: 10px;
            opacity: 0.5;
        }

        html {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }
    </style>
</head>
<body>
<div class="header">
    <!-- Header content -->
    <div class="wrapper">
        <a href="homepage.php">
            <img src="img/book-vault-logo.png" alt="Book Vault Logo" style="width: 250px; height: auto;">
        </a>
    </div>
</div>


<div class="genre-container">
    <div class="arrow left" onclick="scrollGenres('left')">
        <img src="img/left.png" alt="Left Arrow" style="width: 35px; height: 50px;">
    </div>
    <div class="genre-list">
        <?php foreach ($genres as $genre): ?>
            <?php $genreLink = "discover.php?genre=" . urlencode(strtolower($genre)); ?>
            <div class="genre-item">
                <a href="<?php echo $genreLink; ?>"><?php echo ucfirst($genre); ?></a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="arrow right" onclick="scrollGenres('right')">
        <img src="img/right.png" alt="Right Arrow" style="width: 35px; height: 50px;">
    </div>
</div>


<h2 style="text-align: center;">Let's help you embark on your reading journey!</h2>

<?php foreach ($currentGenres as $genre): ?>
    <div class="genre-section" id="<?php echo strtolower($genre); ?>">
        <div class="genre-title"><?php echo ucfirst($genre); ?></div>
        <div class="carousel">
            <div class="carousel-inner">
                <?php
                $books = fetchBooksByGenre($genre);
                if (!empty($books['items'])):
                    foreach ($books['items'] as $book):
                        $volumeInfo = $book['volumeInfo'];
                        $title = isset($volumeInfo['title']) ? $volumeInfo['title'] : 'Title Not Available';
                        $authors = isset($volumeInfo['authors']) ? implode(', ', $volumeInfo['authors']) : 'Unknown';
                        $publishedDate = isset($volumeInfo['publishedDate']) ? $volumeInfo['publishedDate'] : 'Unknown';
                        $description = isset($volumeInfo['description']) ? $volumeInfo['description'] : 'No description available';
                        $bookId = isset($book['id']) ? $book['id'] : '';

                        // Truncate description if too long
                        $description = strlen($description) > 200 ? substr($description, 0, 200) . '...' : $description;

                        // Book image
                        $bookImage = isset($volumeInfo['imageLinks']['thumbnail']) ? $volumeInfo['imageLinks']['thumbnail'] : 'img/default.jpg';
                ?>
                        <div class="book" onclick="location.href='show-book-details.php?bookId=<?php echo $bookId; ?>'">
                            <img src="<?php echo $bookImage; ?>" alt="Book Cover">
                            <div class="book-title"><?php echo $title; ?></div>
                            <div>By <?php echo $authors; ?></div>
                            <div>Published: <?php echo $publishedDate; ?></div>
                         
                        </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p>No books found for this genre.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Pagination -->
<div class="pagination">
    <?php if ($totalPages > 1): ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php $isActive = ($i === $page) ? 'active' : ''; ?>
            <a href="discover.php?page=<?php echo $i; ?>" class="<?php echo $isActive; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    <?php endif; ?>
</div>

<!-- Scroll genres left or right -->
<script>
    function scrollGenres(direction) {
        const genreList = document.querySelector('.genre-list');
        const scrollStep = 200;
        if (direction === 'left') {
            genreList.scrollBy({
                top: 0,
                left: -scrollStep,
                behavior: 'smooth'
            });
        } else if (direction === 'right') {
            genreList.scrollBy({
                top: 0,
                left: scrollStep,
                behavior: 'smooth'
            });
        }
    }
</script>

</body>
</html>
