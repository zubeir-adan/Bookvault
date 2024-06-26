<?php
session_start();

if (isset($_SESSION['logging'])) {
    include_once 'connection.php';
    include_once 'recommendations.php';

    // Retrieve the user's ID from the session
    $userId = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Initialize $recommendedBooks to avoid undefined variable issues
    $recommendedBooks = [];

    // Get user preferences and recommendations
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number
    $preferences = getUserPreferences($userId, $conn);
    if ($preferences) {
        $recommendations = getBookRecommendations($preferences, $page);
        $recommendedBooks = $recommendations['books'];
        $totalPages = $recommendations['totalPages'];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>BookVault - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        /* CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f8f8f8;
            border-bottom: 2px solid #ddd;
            height: 100px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 65px;
        }

        .search-icon {
            margin-left: 20px;
            cursor: pointer;
            border: none;
            background: none;
            padding: 5px 10px;
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .search-icon i {
            font-size: 20px;
            color: black;
        }

        .search-icon:hover {
            background-color: #e2e2e2;
        }

        .nav {
            display: flex;
            align-items: center;
            list-style: none;
            background-color: #f8f8f8;
            padding: 0;
            flex-grow: 1;
            justify-content: center;
        }

        .nav li {
            margin-left: 20px;
            text-align: center;
        }

        .nav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: black;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav a:hover {
            background-color: #e2e2e2;
            color: black;
        }

        .nav img {
            margin-bottom: 5px;
        }

        .welcome {
            display: flex;
            align-items: center;
        }

        .welcome img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .welcome span {
            font-size: 16px;
            color: #333;
        }

        .container {
            text-align: center;
        }

        .logout-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }

        .book-container {
            display: inline-block;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1); /* Reduced opacity */
            text-align: center;
            width: 200px;
            height: 350px; /* Increased height for text content */
            box-sizing: border-box; /* Include padding and border in the width and height */
            overflow: hidden; /* Ensure content stays within container */
            vertical-align: top;
        }

        .book-container img {
            width: 70%;
            height: 60%; /* Maintain aspect ratio */
            border-bottom: 1px solid #ddd; /* Add separator between image and text */
            margin-bottom: 10px; /* Space between image and text */
        }

        .book-container h4, .book-container h6 {
            margin: 5px 0; /* Add some margin to headings */
            font-size: 14px; /* Adjust font size */
            color: #333; /* Text color */
        }

        .book-container h4 {
            font-weight: bold;
        }

        .book-container h6 {
            font-weight: normal;
        }

        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 3px;
            color: #333;
        }

        .pagination a.active {
            background-color: #ddd;
        }

    </style>
</head>
<body>
<div class="header">
    <div class="logo">
        <a href="userloggedin.php">
            <img src="img/book-vault-logo.png" alt="Book Vault">
        </a><br>
        <button class="search-icon" onclick="window.location.href='search2.php'">
            <i class="fa-solid fa-magnifying-glass"></i>
            <br><div>Search</div>
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
    <div class="welcome">
        <img src="img/userr.png" alt="User Image">
        <span>Welcome, <?php echo $username; ?></span>
    </div>
</div>
<div style="text-align: center;">
<h2 style="font-family:Verdana, Geneva, Tahoma, sans-serif;">Recommendations</h2>
<p>Based on your search history, we recommend the following books:</p>
</div>

<div class="container">
    <?php
    foreach ($recommendedBooks as $book) {
        echo "<div class='book-container'>";
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
    ?>
</div>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="userloggedin.php?page=<?php echo $page - 1; ?>">Previous</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="userloggedin.php?page=<?php echo $i; ?>" class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="userloggedin.php?page=<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>

<div class="container">
    <form method="post" action="userlogout.php">
        <input type="submit" value="Logout" class="logout-button">
    </form>
</div>
<?php } else {
    header('Location: homepage.php');
}
?>
<?php include("body/footer.php")?>
</body>
</html>
