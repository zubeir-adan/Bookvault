<?php
// discover.php

// Genres to search for
$genres = [
    'thriller', 'suspense', 'fantasy', 'historical', 'autobiography', 'self help',
    'science', 'junior fiction', 'action', 'romance', 'poetry', 'technology', 
    'health and fitness', 'adventure', 'science fiction', 'mystery', 'crime', 
    'horror', 'westerns', 'comedy', 'biography', 'arts and crafts', 'food and cooking', 
    'history', 'wildlife', 'drama', 'religion and spirituality', 'travel', 'business and finance', 
    'psychology', 'philosophy', 'education', 'music', 'art', 'sports', 'true crime', 'fashion', 
    'gardening', 'parenting', 'crafts and hobbies', 'humor', 'reference', 'diary', 'journal', 
    'encyclopedia', 'languages', 'law', 'mathematics', 'medical', 'nature', 'politics', 
    'social sciences', 'transportation', 'trivia', 'young adult', 'children', 'cooking', 
    'home improvement', 'photography', 'graphic novels', 'comic books', 'magazines', 
    'newspapers', 'plays', 'screenplays', 'short stories'
];

function fetchBooksByGenre($genre) {
    $url = 'https://www.googleapis.com/books/v1/volumes?q=subject:' . urlencode($genre);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Pagination settings
$genresPerPage = 5; // Adjust as needed
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Discover</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .genre-section {
            margin-bottom: 40px;
        }

        .genre-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .carousel {
            display: flex;
            overflow-x: scroll; /* Enable horizontal scrolling */
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
            /* New styles for cursor and hover effect */
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

        /* Hover effect */
        .book:hover {
            transform: scale(1.05);
        }

        ::-webkit-scrollbar {
            width: 10px;
            /* Adjust the width of the scrollbar */
            opacity: 0.5;
            /* Adjust the opacity */
        }

        html {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
            /* Adjust the color */
        }
    </style>
</head>
<body>
<?php include("body/header2.php"); ?>
<h2 style="text-align: center;">Let's help you embark on your reading journey!</h2>
<h3 style="text-align: center;">Over 60 genres to choose from</h3>

    <?php foreach ($currentGenres as $genre): ?>
        <div class="genre-section">
            <div class="genre-title"><?php echo ucfirst($genre); ?></div>
            <div class="carousel" id="carousel-<?php echo $genre; ?>">
                <div class="carousel-inner">
                    <?php
                    $books = fetchBooksByGenre($genre);
                    if (!empty($books['items'])):
                        foreach ($books['items'] as $book):
                            $volumeInfo = $book['volumeInfo'];
                            $title = $volumeInfo['title'];
                            $thumbnail = isset($volumeInfo['imageLinks']['thumbnail']) ? $volumeInfo['imageLinks']['thumbnail'] : 'img/default.jpg';
                            ?>
                            <div class="book">
                                <a href="show-book-details2.php?bookId=<?php echo urlencode($book['id']); ?>" style="text-decoration: none; color: inherit;">
                                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo htmlspecialchars($title); ?>">
                                    <div class="book-title"><?php echo htmlspecialchars($title); ?></div>
                                </a>
                            </div>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <div>No books found for <?php echo htmlspecialchars($genre); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div style="text-align: center; margin-top: 20px;">
    <!-- Pagination links -->
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>" style="padding: 8px 12px; background-color: #f7f7f8; color: #333; text-decoration: none; border: 1px solid #ddd; border-radius: 5px; transition: background-color 0.3s ease;">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
            <strong style="padding: 8px 12px; background-color: #87CEEB; color: #fff; text-decoration: none; border: 1px solid #ddd; border-radius: 5px;"><?php echo $i; ?></strong>
        <?php else: ?>
            <a href="?page=<?php echo $i; ?>" style="padding: 8px 12px; background-color: #f7f7f8; color: #333; text-decoration: none; border: 1px solid #ddd; border-radius: 5px; transition: background-color 0.3s ease;"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>" style="padding: 8px 12px; background-color: #f7f7f8; color: #333; text-decoration: none; border: 1px solid #ddd; border-radius: 5px; transition: background-color 0.3s ease;">Next</a>
    <?php endif; ?>
</div>
<br><br>
    <?php include("body/footer.php"); ?>
</body>
</html>
