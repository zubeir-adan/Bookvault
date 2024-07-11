<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['logging'])) {
    include_once 'connection.php';
    include_once 'recommendations.php';

    // Retrieve the user's ID from the session
    $userId = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Pagination settings
    $limit = 10; // Number of books per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number
    $offset = ($page - 1) * $limit; // Calculate the offset for the SQL query

    // Initialize $recommendedBooks to avoid undefined variable issues
    $recommendedBooks = [];
    $totalBooks = 0;

    // Get user preferences and recommendations
    $preferences = getUserPreferences($userId, $conn);
    if ($preferences) {
        $recommendations = getBookRecommendations($preferences, $page, $limit, $conn); // Pass limit for recommendations
        $recommendedBooks = $recommendations['books'];
        $totalBooks = $recommendations['totalBooks']; // Get the total number of books
        $totalPages = ceil($totalBooks / $limit); // Calculate the total number of pages
    } else {
        $totalPages = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reader's Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="user.css">
    <style>
        /* Add your custom styles here */
        .dropdown {
            position: relative;
            display: inline-block;
            margin-right: 0px;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            min-width: 160px;
            padding: 10px;
            right: 0;
            top: 50px;
        }
        .dropdown-content a {
            color: black;
            padding: 5px 10px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover { background-color: #f1f1f1; }
        .dropdown.show .dropdown-content { display: block; }
        .dropdown .user-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer; /* Add cursor pointer to indicate it's clickable */
        }

        .book-container {
            transition: transform 0.3s;
        }
        .book-container:hover {
            transform: scale(1.05);
        }
        .book-container a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="logo">
        <a href="userloggedin.php">
            <img src="img/book-vault-logo.png" alt="Book Vault">
        </a>
        
        <button class="search-icon" onclick="window.location.href='search2.php'">
            <i class="fa-solid fa-magnifying-glass"></i>
            <br><div>Search</div>
        </button>

        <button class="discover-icon" onclick="window.location.href='discover2.php'">
            <i class="fa-solid fa-compass"></i>
            <br><div>Discover</div>
        </button>
    </div>
    <ul class="nav">
        <li>
            <a href="analytics-view.php">
                <img src="img/analyticss.png" alt="Analytics" width="35" height="35">
                Analytics
            </a>
        </li>
        <li>
            <a href="mycollection-view.php">
                <img src="img/mycollection.png" alt="My Collection" width="35" height="35">
                My Collection
            </a>
        </li>
        <li>
            <a href="haveread-view.php">
                <img src="img/haveread.png" alt="Have Read" width="35" height="35">
                Have Read
            </a>
        </li>
        <li>
            <a href="toread-view.php">
                <img src="img/wanttoread.png" alt="Want To Read" width="35" height="35">
                Want To Read
            </a>
        </li>
        <li>
            <a href="favourite-view.php">
                <img src="img/fav.png" alt="Favourites" width="35" height="35">
                Favourites
            </a>
        </li>
    </ul>
    <div class="dropdown" id="dropdown">
        <img src="img/userr.png" alt="User Image" class="user-image" onclick="toggleDropdown()">
        <div class="dropdown-content" id="dropdownContent">
            <a href="usereditdetails.php">Account</a>
            <a href="userlogout.php">Logout</a>
        </div>
        <span class="username">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
    </div>
</div>

<div style="text-align: center;">
    <h2>Recommendations</h2>
    <?php if (empty($recommendedBooks)) : ?>
        <p>To get you started on recommendations, Search for a book author of your choice.</p>
    <?php else : ?>
        <p>Based on your search history, we recommend the following books:</p>
    <?php endif; ?>
</div>

<div class="container">
    <?php foreach ($recommendedBooks as $book): ?>
        <div class="book-container">
            <a href="show-book-details2.php?bookId=<?php echo urlencode($book['id']); ?>">
                <div class="book-image-container">
                    <?php if (isset($book['volumeInfo']['imageLinks']['thumbnail'])) : ?>
                        <img src="<?php echo htmlspecialchars($book['volumeInfo']['imageLinks']['thumbnail']); ?>" alt="Book Cover" class="book-image">
                    <?php else : ?>
                        <img src="img/default.jpg" alt="Book image not found!" class="book-image">
                    <?php endif; ?>
                </div>
                <div class="book-details">
                    <h4><?php echo isset($book['volumeInfo']['title']) ? htmlspecialchars($book['volumeInfo']['title']) : "Title Not Available"; ?></h4>
                    <h6>By: <?php echo isset($book['volumeInfo']['authors']) ? implode(", ", array_map('htmlspecialchars', $book['volumeInfo']['authors'])) : "Unknown"; ?></h6>
                  
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>


<div style="text-align: center; margin-top: 20px;">
    <div class="pagination">
        <?php if ($totalPages > 1) : ?>
            <?php if ($page > 1) : ?>
                <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <?php if ($i == $page) : ?>
                    <span><?php echo $i; ?></span>
                <?php else : ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<br><br>

<?php include("body/footer.php"); ?>

<script>
    function toggleDropdown() {
        var dropdown = document.getElementById('dropdown');
        dropdown.classList.toggle('show');
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.closest('.dropdown')) {
            var dropdowns = document.getElementsByClassName('dropdown');
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

</body>
</html>

<?php
} else {
    header('Location: homepage.php');
    exit();
}
?>
