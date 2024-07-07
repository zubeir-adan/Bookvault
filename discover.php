<?php
// discover.php

// Genres to search for
$genres = ['romance', 'mystery', 'crime', 'horror', 'science fiction', 'thriller', 'suspense', 'westerns', 'historical', 'fantasy', 'comedy', 'autobiography', 'biography', 'arts and crafts', 'food and cooking', 'history', 'self help', 'wildlife', 'science', 'junior fiction', 'action and adventure', 'drama', 'poetry', 'religion and spirituality', 'travel', 'business and finance', 'technology', 'health and fitness', 'psychology', 'philosophy', 'education', 'music', 'art', 'sports', 'true crime', 'fashion', 'gardening', 'parenting', 'crafts and hobbies', 'humor', 'reference', 'diary', 'journal', 'encyclopedia', 'languages', 'law', 'mathematics', 'medical', 'nature', 'politics', 'social sciences', 'transportation', 'trivia', 'young adult', 'children', 'cooking', 'home improvement', 'photography', 'graphic novels', 'comic books', 'magazines', 'newspapers', 'plays', 'screenplays', 'short stories'];

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
?>

<!DOCTYPE html>
<html>
<head>
    <title style="text-align: center;">Discover</title>
    <style>
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
        ::-webkit-scrollbar {
            width: 10px;
            opacity: 0.5;
        }
        html {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }
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
    </style>
</head>
<body>
<div class="header">
    <div class="wrapper">
        <img src="img/book-vault-logo.png" alt="Book Vault Logo" style="width: 250px; height: auto;">
    </div>
</div>

<h2 style="text-align: center;">Let's help you embark on your reading journey!</h2>

<?php foreach ($currentGenres as $genre): ?>
    <div class="genre-section">
        <div class="genre-title"><?php echo ucfirst($genre); ?></div>
        <div class="carousel overflow-x-scroll" id="carousel-<?php echo $genre; ?>">
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
                            <a href="show-book-details.php?bookId=<?php echo urlencode($book['id']); ?>" style="text-decoration: none; color: inherit;">
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

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="discover.php?page=<?php echo $page - 1; ?>">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="discover.php?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="discover.php?page=<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>

<?php include("body/footer.php"); ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php foreach ($currentGenres as $genre): ?>
        const carousel<?php echo $genre; ?> = document.getElementById('carousel-<?php echo $genre; ?>');
        <?php endforeach; ?>
    });
</script>
</body>
</html>
