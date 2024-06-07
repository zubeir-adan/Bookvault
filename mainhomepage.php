<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to BookVault</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f1f1f1;
            border-bottom: 2px solid #ddd;
            height: 100px;
        }
        .logo {
            height: 70px;
            margin-top: -20px;
        }
        .menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .menu li {
            display: inline;
        }
        .menu a {
            text-decoration: none;
            color: black;
            padding: 10px;
        }
        .header-buttons {
            display: flex;
            gap: 10px;
        }
        .header-buttons button {
            background-color: #808080;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .header-buttons button:hover {
            background-color: #45a049;
        }
        .Intro {
            position: relative;
            background: url('img/vaultimg.png') no-repeat center center/cover;
            height: 100vh;
            color: black;
            text-align: left;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .Intro h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }
        .Intro p {
            font-size: 1.2em;
            line-height: 1.5;
        }
        .about-us {
            padding: 50px 20px;
            text-align: center;
            background-color: #f9f9f9;
        }
        .about-us h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .about-us p {
            font-size: 1.2em;
            line-height: 1.5;
        }
        .sign-up {
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .sign-up button {
            background-color: green;
            border: none;
            color: white;
            padding: 10px 30px;
            font-size: 24px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .sign-up button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="img/book-vault-logo.png" alt="Book Vault" class="logo">
        <ul class="menu">
            <li class="suggest">
                <a href="search.php">
                    <i class="fas fa-search"></i> Search Book
                </a>
            </li>
        </ul>
        <div class="header-buttons">
            <button type="button" id="Discover">Discover</button>
            <button type="button" id="login">Log In</button>
        </div>
    </div>

    <section class="Intro">
        <div class="content">
            <h1>Welcome to BookVault</h1>
            <p>
                Discover a world of books at your fingertips. Join us to explore and enjoy an extensive collection of books.
            </p>
        </div>
    </section>

    <section class="about-us">
        <h1>About Us</h1>
        <p>
            BookVault is designed to be your personal assistant in enghancing and tracking your literary journey. Designed by two avid readers, we know your thirsts, and exactly how to quench them.
        </p>
    </section>

    <div class="sign-up">
        <button id="sign-up">Embark</button>
    </div>

    <script>
        document.getElementById('Discover').addEventListener('click', function() {
            window.location.href = 'discover.php';
        });
        document.getElementById('login').addEventListener('click', function() {
            window.location.href = 'userlogin.html';
        });
        document.getElementById('sign-up').addEventListener('click', function() {
            window.location.href = 'usersignup.html';
        });
    </script>
</body>
</html>
