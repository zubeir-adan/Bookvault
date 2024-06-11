<?php
// discover.php

// Genres to search for
$genres = ['romance', 'mystery', 'crime', 'horror', 'science fiction', 'thriller', 'suspense', 'westerns', 'historical', 'fantasy', 'comedy', 'autobiography', 'biography', 'arts and crafts', 'food and cooking', 'history', 'self help', 'wildlife', 'science', 'junior fiction', 'action and adventure', 'drama', 'poetry', 'religion and spirituality', 'travel', 'business and finance', 'technology', 'health and fitness', 'psychology', 'philosophy', 'education', 'music', 'art', 'sports', 'true crime', 'fashion', 'gardening', 'parenting', 'crafts and hobbies', 'humor', 'reference', 'diary', 'journal', 'encyclopedia', 'languages', 'law', 'mathematics', 'medical', 'nature', 'politics', 'social sciences', 'transportation', 'trivia', 'young adult', 'children', 'cooking', 'home improvement', 'photography', 'graphic novels', 'comic books', 'magazines', 'newspapers', 'plays', 'screenplays', 'short stories'];

function fetchBooksByGenre($genre) {
    $url = 'https://www.googleapis.com/books/v1/volumes?q=subject:' . urlencode($genre);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

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
    z-index: 1000; /* Ensure it's above other content */
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
<div class="header">
    <div class="wrapper">
        <img src="img/book-vault-logo.png" alt="Book Vault Logo" style="width: 100px; height: auto;">
        <h4 style="text-align: left;">Revolutionize Reading!</h4>
    </div>
</div>

<h2 style="text-align: center;">Let's help you embark on your reading journey!</h2>
<?php
 foreach ($genres as $genre): ?>
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
<?php include("body/footer.php"); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php foreach ($genres as $genre): ?>
        const carousel<?php echo $genre; ?> = document.getElementById('carousel-<?php echo $genre; ?>');
        <?php endforeach; ?>
    });
</script>
</body>
</html>
