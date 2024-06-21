<html>
<head>
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="css/style.css" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
     integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
      <style>

/* CSS Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.wrapper {
    width: 100%;
}

.nav {
    display: flex;
    align-items: right;
    justify-content: space-between;
    list-style: none;
    background-color: #f8f8f8; /* Adjust as needed */
    padding: 10px 20px;
}

.nav .logo {
    position: absolute;
    top: 10px; /* Adjust as needed */
    left: -230px; /* Adjust as needed */
   
}

.nav li {
    margin-left: 20px;
}
.nav .suggest {
    position: absolute;
    top: 5px; /* Adjust as needed */
    right: 40px; /* Adjust as needed */
}

.nav .suggest a {
    display: flex;
    align-items: center;
}

.nav .suggest a i {
    margin-right: 5px;
}

.nav li:not(.logo):not(.suggest) {
    flex: 1;
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: flex-start;
    margin-top: 20px;
}

.nav li:not(.logo):not(.suggest) a {
    display: flex;
    align-items: center;
}

/* Ensure the other elements are aligned correctly */
.nav .books, .nav .movies, .nav .music, .nav .muzic {
    flex: 1;
}

.nav img {
    margin-right: 10px;
}




        </style>
</head>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyDQb9CSLW7L066B4XxPkEzLn4rxpFmVfnY",
    authDomain: "bookvault-d3402.firebaseapp.com",
    databaseURL: "https://bookvault-d3402-default-rtdb.firebaseio.com",
    projectId: "bookvault-d3402",
    storageBucket: "bookvault-d3402.appspot.com",
    messagingSenderId: "707835170990",
    appId: "1:707835170990:web:0d52971293bc2e6cad1d3f",
    measurementId: "G-568P1C3MZW"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>

<body>

	<div class="header">

    <div class="wrapper">
    <ul class="nav">
        <li class="logo">
            <a href="homepage.php">
                <img src="img/book-vault-logo.png" alt="Book Vault" class="logo">
            </a>
        </li>
        <li class="suggest">
            <a href="search.php">
                <i class="fa-solid fa-magnifying-glass"></i> Search Book
            </a>
        </li>
        <li class="books">
            <a href="haveread-view.php">
                <img src="img/haveread.png" alt="Have Read" width="35" height="35"> Have Read
            </a>
        </li>
        <li class="movies">
            <a href="toread-view.php">
                <img src="img/wanttoread.png" alt="Want To Read" width="35" height="35"> Want To Read
            </a>
        </li>
        <li class="music">
            <a href="favourite-view.php">
                <img src="img/fav.png" alt="Favourites" width="35" height="35"> Favourites
            </a>
        </li>
        <li class="books">
            <a href="haveread-view.php">
                <img src="img/user.jpeg" alt="Have Read" width="35" height="35"> Welcome
            </a>
        </li>
    </ul>
</div>


	</div>

	<div id="content">