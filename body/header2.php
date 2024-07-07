<?php
// Start the session at the beginning of the file
session_start();

// Check if the user is logged in and the username is set in the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // If the username is not set, you can redirect the user to the login page or set a default value
    $username = 'Guest'; // or handle the error appropriately
    // header('Location: login.php'); // Redirect to login page
    // exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
/* CSS for header and logo */
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
    margin-left: 15px; /* Adjusted margin */
    cursor: pointer;
    border: none;
    background: none;
    padding: 5px 10px; /* Adjusted padding */
    border-radius: 1px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s;
}
.discover-icon {
    margin-left: 30px; /* Adjusted margin */
    cursor: pointer;
    border: none;
    background: none;
    padding: 5px 10px; /* Adjusted padding */
    border-radius: 1px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s;
}

.search-icon i, .discover-icon i {
    font-size: 20px;
    color: black;
}

.search-icon:hover, .discover-icon:hover {
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
    top: 60px;
}

.dropdown-content a {
    color: black;
    padding: 5px 10px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown.show .dropdown-content {
    display: block;
}

.dropdown .user-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    /* Add cursor pointer to indicate it's clickable */
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
        <span class="username">Hi <?php echo $username; ?></span>
    </div>
</div>

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
