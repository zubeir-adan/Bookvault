<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Searching</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
form {
    position: relative; /* Make sure the form is positioned relative */
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
    position: relative; /* Make sure the container is positioned */
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
    transition: all 0.3s ease; /* Smooth transition for hover effects */
}

.book-container img {
    width: 40%; /* Adjust image width to fit container */
    height: auto;
    transition: transform 0.3s ease; /* Smooth transition for scale effect */
}

.book-container:hover img {
    transform: scale(1.1); /* Slightly scale up the image on hover */
}

.book-info {
    position: absolute; /* Position the book details absolutely within the container */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
    color: #333;
    visibility: hidden; /* Start with info hidden */
    opacity: 0;
    transition: visibility 0s, opacity 0.3s linear;
}

.book-container:hover .book-info {
    visibility: visible; /* Make details visible on hover */
    opacity: 1;
}

.loader {
    border: 6px solid lightcyan;
    border-top: 6px solid #3498db;
    border-radius: 70%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
    margin: 0 auto;
    display: none;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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
    max-width: 520px; /* Limit the width of the suggestion box */
    margin: 0 auto; /* Center the suggestion box */
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

<div class="loader"></div>
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
    echo "<script>document.querySelector('.loader').style.display = 'none';</script>";
}
?>


</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const autocompleteList = document.getElementById('autocomplete-list');
    const searchForm = document.querySelector('form');
    const loader = document.querySelector('.loader'); // Get the loader element

    // Listener for input on the search box
    searchInput.addEventListener('input', function() {
        let input = this.value;

        // Clear the autocomplete list and hide if input length is less than 3
        if (input.length < 3) {
            autocompleteList.innerHTML = '';
            return;
        }

        // Display the loader when starting to fetch data
        loader.style.display = 'block';
        console.log("Fetching books for:", input); // Debug log for input

        // Fetch data from Google Books API
        fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(input)}&maxResults=5`)
        .then(response => response.json())
        .then(data => {
            console.log("Data received:", data); // Debug log for fetched data
            let books = data.items || [];
            autocompleteList.innerHTML = '';

            // Populate autocomplete list with fetched book titles
            books.forEach(book => {
                let title = book.volumeInfo.title;
                let div = document.createElement('div');
                div.textContent = title;
                div.onclick = function() {
                    console.log("Book clicked:", title); // Debug log for clicked book title
                    searchInput.value = title;
                    autocompleteList.innerHTML = '';
                    searchForm.submit(); // Automatically submit the form on click
                };
                autocompleteList.appendChild(div);
            });

            // Hide the loader after processing data
            loader.style.display = 'none';
        })
        .catch(error => {
            console.error('Error fetching autocomplete suggestions:', error);
            loader.style.display = 'none'; // Ensure loader is hidden on fetch error
        });
    });

    // Hide autocomplete list when clicking anywhere else on the body
    document.body.addEventListener('click', function(event) {
        if (event.target !== searchInput) {
            autocompleteList.innerHTML = '';
        }
    });
});

// Function to redirect to show book details page
function showBookDetails(bookId) {
    window.location.href = 'show-book-details.php?bookId=' + bookId;
}
</script>

<?php include("body/footer.php"); ?>

</body>
</html>
