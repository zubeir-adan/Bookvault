<!DOCTYPE html>
<html lang="en">
<head>
<meta chrset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Searching</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
form {
    position: relative;
    text-align: center;
    margin-top: 30px;
}
input[type="text"] {
    width: 40%;
    padding: 15px;
    border-radius: 10px;
    font-size: 16px;
}
button {
    padding: 15px 10px;
    background-color: #708ee6;
    color: white;
    border: none;
    border-radius: 10px;
    margin-left: 10px;
}
.book-container {
    position: relative;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin: 10px;
    padding: 10px;
    cursor: pointer;
    width: 200px;
    height: 300px;
    overflow: hidden;
    vertical-align: top;
    text-align: center;
    transition: all 0.3s ease;
}
.book-container img {
    width: 40%;
    height: auto;
    transition: transform 0.3s ease;
}
.book-container:hover img {
    transform: scale(1.1);
}
.book-info {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    color: #333;
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s, opacity 0.3s linear;
}
.book-container:hover .book-info {
    visibility: visible;
    opacity: 1;
}
.loader-container {
    display: none;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    z-index: 1000;
}
.loader-spanne-20 {
    position: relative;
    width: 100px;
    height: 30px;
    padding: 0;
}
.loader-spanne-20 > span {
    position: absolute;
    right: 0;
    width: 3px;
    height: 30px;
    background-color: rgb(116, 204, 197);
    display: block;
    border-radius: 3px;
    transform-origin: 50% 100%;
    animation: move 2.8s linear infinite;
}
.loader-spanne-20 > span:nth-child(1) {
    animation-delay: -0.4s;
}
.loader-spanne-20 > span:nth-child(2) {
    animation-delay: -0.8s;
}
.loader-spanne-20 > span:nth-child(3) {
    animation-delay: -1.2s;
}
.loader-spanne-20 > span:nth-child(4) {
    animation-delay: -1.6s;
}
.loader-spanne-20 > span:nth-child(5) {
    animation-delay: -2s;
}
.loader-spanne-20 > span:nth-child(6) {
    animation-delay: -2.4s;
}
.loader-spanne-20 > span:nth-child(7) {
    animation-delay: -2.8s;
}
@keyframes move {
    0% {
        opacity: 0;
        transform: translateX(0px) rotate(0deg);
    }
    20% {
        opacity: 1;
    }
    40% {
        transform: translateX(-40px) rotate(0deg);
    }
    50% {
        opacity: 1;
        transform: translateX(-50px) rotate(22deg);
    }
    85% {
        opacity: 1;
        transform: translateX(-85px) rotate(60deg);
    }
    100% {
        opacity: 0;
        transform: translateX(-100px) rotate(65deg);
    }
}
.autocomplete-items {
    position: absolute;
    border: 1px solid #d4d4d4;
    border-top: none;
    z-index: 99;
    top: 100%;
    left: 0;
    right: 4%;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-radius: 0 0 10px 10px;
    overflow: hidden;
    max-width: 520px;
    margin: 0 auto;
}
.autocomplete-items div {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #d4d4d4;
    background-color: #fff;
    text-align: left;
}
.autocomplete-items div:hover {
    background-color: #e9e9e9;
}
.autocomplete-items .autocomplete-active {
    background-color: #d4d4d4;
}
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
.book-list {
    flex: 1;
}
</style>
</head>
<body>
<?php include("body/header.php"); ?>
<div class="book-list">
    <form method="get" action="">
        <input type="text" name="search" id="search-input" placeholder="Search for a book" autocomplete="off">
        <button type="submit" name="submit-search"><i class="fa-solid fa-search"></i></button>
        <div id="autocomplete-list" class="autocomplete-items"></div>
    </form>

    <div class="loader-container">
        <div class="loader-spanne-20">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class='book-info'>
        <h3>${htmlspecialchars($book['volumeInfo']['title'])}</h3>
        <p>Author(s): ${implode(", ", array_map('htmlspecialchars', $book['volumeInfo']['authors']))}</p>
        <p>Publish Year: ${htmlspecialchars($book['volumeInfo']['publishedDate'])}</p>
    </div>
</div>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<?php
function searchBooks($query) {
    $base_url = 'https://www.googleapis.com/books/v1/volumes?q=';
    $url = $base_url . urlencode($query);
    $response = file_get_contents($url);
    if ($response === false) {
        echo "Failed to fetch data from Google Books API.";
        return false;
    }
    $data = json_decode($response, true);
    if (!$data || !isset($data['items'])) {
        echo "No books found for the query: " . htmlspecialchars($query);
        return false;
    }
    return $data['items'];
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $query = $_GET['search'];
    $books = searchBooks($query);
    if ($books) {
        echo "<div class='book-list'>";
        echo "<h5 style='text-align: center'>Search Results for: " . htmlspecialchars($query) . "</h5>";
        foreach ($books as $book) {
            echo "<div class='book-container' onclick='showBookDetails(\"" . htmlspecialchars($book['id']) . "\")'>";
            if (isset($book['volumeInfo']['imageLinks']['thumbnail'])) {
                echo "<img src='" . htmlspecialchars($book['volumeInfo']['imageLinks']['thumbnail']) . "' alt='Book Cover'>";
            } else {
                echo "<img src='img/default.jpg' alt='Book image not found!' width='100' height='150'>";
            }
            if (isset($book['volumeInfo']['title'])) {
                echo "<h4>" . htmlspecialchars($book['volumeInfo']['title']) . "</h4>";
            } else {
                echo "<h4>Title Not Available</h4>";
            }
            if (isset($book['volumeInfo']['authors'])) {
                echo "<h6>Author(s): " . implode(", ", array_map('htmlspecialchars', $book['volumeInfo']['authors'])) . "</h6>";
            } else {
                echo "<h6>Author(s): Unknown</h6>";
            }
            if (isset($book['volumeInfo']['publishedDate'])) {
                echo "<h6>Publish Year: " . htmlspecialchars($book['volumeInfo']['publishedDate']) . "</h6>";
            } else {
                echo "<h6>Publish Year: Unknown</h6>";
            }
            echo "</div>";
        }
        echo "</div>";
    }
    echo "<script>document.querySelector('.loader-container').style.display = 'none';</script>";
}
?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const autocompleteList = document.getElementById('autocomplete-list');
    const searchForm = document.querySelector('form');
    const loaderContainer = document.querySelector('.loader-container');

    // Ensure loader is hidden on initial page load
    loaderContainer.style.display = 'none';

    // Listener for input on the search box
    searchInput.addEventListener('input', function() {
        let input = this.value;

        // Clear the autocomplete list and hide if input length is less than 3
        if (input.length < 3) {
            autocompleteList.innerHTML = '';
            return;
        }

        // Display the loader when starting to fetch data
        loaderContainer.style.display = 'flex';
        console.log("Fetching books for:", input);

        // Fetch data from Google Books API
        fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(input)}&maxResults=5`)
        .then(response => response.json())
        .then(data => {
            console.log("Data received:", data);
            let books = data.items || [];
            autocompleteList.innerHTML = '';

            // Populate autocomplete list with fetched book titles
            books.forEach(book => {
                let title = book.volumeInfo.title;
                let div = document.createElement('div');
                div.textContent = title;
                div.onclick = function() {
                    console.log("Book clicked:", title);
                    searchInput.value = title;
                    autocompleteList.innerHTML = '';
                    loaderContainer.style.display = 'flex'; // Show the loader when a book is clicked
                    searchForm.submit();
                };
                autocompleteList.appendChild(div);
            });

            // Hide the loader after processing data
            loaderContainer.style.display = 'none';
        })
        .catch(error => {
            console.error('Error fetching autocomplete suggestions:', error);
            loaderContainer.style.display = 'none'; // Ensure loader is hidden on fetch error
        });
    });

    // Hide autocomplete list when clicking anywhere else on the body
    document.body.addEventListener('click', function(event) {
        if (event.target !== searchInput) {
            autocompleteList.innerHTML = '';
        }
    });

    // Stop the loader when navigating back to the page
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            loaderContainer.style.display = 'none';
        }
    });
});

// Function to redirect to show book details page
function showBookDetails(bookId) {
    const loaderContainer = document.querySelector('.loader-container');
    loaderContainer.style.display = 'flex'; // Show the loader when a book is clicked
    window.location.href = 'show-book-details.php?bookId=' + bookId;
}
</script>

<?php include("body/footer.php"); ?>
</body>
</html>
