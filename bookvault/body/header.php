<html>
<head>
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="css/style.css" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
     integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
      <style>
        .header {
    background: #f7f7f8;
    border-bottom: 3px solid  #87CEEB;
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

        </style>
</head>

<body>

	<div class="header">

		<div class="wrapper">

			<h1 class="branding-title"><a href="homepage.php"></a></h1>

			<ul class="nav">
                
                <li class="books">
                    <a href="haveread-view.php">
                        <i class="fa-solid fa-book">

                        </i>    Have Read</a></li>

                <li class="movies">
                    <a href="toread-view.php">
                        <i class="fa-solid fa-bookmark">
                     </i>   Want To Read</a></li>

                <li class="music"> 
                    <a href="favourite-view.php">
                        <i class="fa-solid fa-star">
                    </i>    Favourites</a></li>

                <li class="muzic">
                    <a href="catalog.php?cat=music">
                      
                        </i> </a></li>

                <li class="suggest">
                    <a href="search.php">
                        <i class="fa-solid fa-magnifying-glass">
                        </i>    Search Book</a></li>
            </ul>

		</div>

	</div>

	<div id="content">