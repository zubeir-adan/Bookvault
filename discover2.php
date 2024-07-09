<?php
// discover2.php

// Genres to search for (can be the same as in discover.php or different)
$genres = [
    'action ','adventure', 'art', 'arts and crafts', 'autobiography', 'biography',
    'business and finance', 'children', 'cooking', 'comic books', 'crafts and hobbies',
    'crime', 'drama', 'education', 'encyclopedia', 'fashion',
    'fantasy', 'food and cooking', 'gardening', 'graphic novels', 'health and fitness',
    'historical', 'history', 'home improvement', 'horror', 'humor',
    'junior fiction', 'languages', 'law', 'magazines', 'mathematics','manga',
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

// Function to fetch books by genre from Google Books API (same as discover.php)
function fetchBooksByGenre($genre) {
    $url = 'https://www.googleapis.com/books/v1/volumes?q=subject:' . urlencode($genre);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Pagination settings (similar to discover.php)
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

// Check if a specific genre is requested (similar logic as discover.php)
$requestedGenre = isset($_GET['genre']) ? strtolower($_GET['genre']) : '';

// Find the page where the requested genre is located (similar logic as discover.php)
if (!empty($requestedGenre)) {
    $genreIndex = array_search($requestedGenre, array_map('strtolower', $genres));
    if ($genreIndex !== false) {
        $page = ceil(($genreIndex + 1) / $genresPerPage);
        $startIndex = ($page - 1) * $genresPerPage;
        $currentGenres = array_slice($genres, $startIndex, $genresPerPage);
    }
}
?>
<?php include("body/header2.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover </title>
  
    <style>
        /* Genre container styles */
        .genre-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0; /* Adjusted margin to remove the space */
            position: relative;
            padding: 10px 0;
            background-color: skyblue;
        }

        .genre-list {
            display: flex;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            width: calc(100% - 60px);
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
            top: 40%;
            transform: translateY(-50%);
            background-color: white;
            border: 1px solid black;
            border-radius: 70%;
            width: 30px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000; /* Ensure arrows are above other content */
        }

        .arrow.left {
            left: 20px; /* Adjust position from the left */
            background-image: url('img/left.png'); /* Add left arrow image */
            background-size: cover;
        }

        .arrow.right {
            right: 10px; /* Adjust position from the right */
            background-image: url('img/right.png'); /* Add right arrow image */
            background-size: cover;
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
            font-weight: bold;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: large;
            word-wrap: break-word;
        }
        .book-published-date {
            font-size: medium;
            color: #666;
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

<div class="genre-container">
    <div class="arrow left" onclick="scrollGenres('left')">
        <!-- Left arrow image (included in CSS) -->
    </div>
    <div class="genre-list">
        <!-- Genre list (similar to discover.php) -->
        <?php foreach ($genres as $genre): ?>
            <?php $genreLink = "discover2.php?genre=" . urlencode(strtolower($genre)); ?>
            <div class="genre-item">
                <a href="<?php echo $genreLink; ?>"><?php echo ucfirst($genre); ?></a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="arrow right" onclick="scrollGenres('right')">
        <!-- Right arrow image (included in CSS) -->
    </div>
</div>

<h2 style="text-align: center;">Let's help you embark on your literaly journey</h2>
<h2 style="text-align: center;">Over 60 genres to choose from</h2>

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
                        $thumbnail = isset($volumeInfo['imageLinks']['thumbnail']) ? $volumeInfo['imageLinks']['thumbnail'] : 'img/default.jpg';
                ?>
                        <div class="book">
                        <a href="show-book-details2.php?bookId=<?php echo urlencode($book['id']); ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?php echo $thumbnail; ?>" alt="<?php echo htmlspecialchars($title); ?>">
                            <div class="book-title"><?php echo htmlspecialchars($title); ?></div><br>
                            <div class="book-authors">Written by : <?php echo htmlspecialchars($authors); ?></div><br>
                            <div class="book-published-date">Published in: <?php echo htmlspecialchars($publishedDate); ?></div>
                        </div>
                <?php
                    endforeach;
                else:
                    echo "<p>No books found for this genre.</p>";
                endif;
                ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
    <?php endif; ?>
</div>

<script>
function scrollGenres(direction) {
    const genreList = document.querySelector('.genre-list');
    const scrollAmount = 100; // Adjust as needed
    if (direction === 'left') {
        genreList.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else if (direction === 'right') {
        genreList.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}
</script>
</body>
</html>
<?php include("body/footer.php"); ?>
