<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to BookVault</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .carousel-container {
            margin-bottom: 100px;
        }
        .carousel {
            margin: 30px auto 60px;
            padding: 0 80px;
        }
        .carousel .carousel-item {
            text-align: center;
            overflow: hidden;
        }
        .carousel .carousel-item h4 {
            font-family: 'Varela Round', sans-serif;
        }
        .carousel .carousel-item img {
            max-width: 100%;
            display: inline-block;
        }
        .carousel .carousel-item .btn {
            border-radius: 0;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
            border: none;
            background: #a177ff;
            padding: 6px 15px;
            margin-top: 5px;
        }
        .carousel .carousel-item .btn:hover {
            background: #8c5bff;
        }
        .carousel .carousel-item .btn i {
            font-size: 14px;
            font-weight: bold;
            margin-left: 5px;
        }
        .carousel .thumb-wrapper {
            margin: 5px;
            text-align: left;
            background: #fff;
            box-shadow: 0px 2px 2px rgba(0,0,0,0.1);   
        }
        .carousel .thumb-content {
            padding: 15px;
            font-size: 13px;
        }
        .carousel-control-prev, .carousel-control-next {
            height: 44px;
            width: 44px;
            background: none;    
            margin: auto 0;
            border-radius: 50%;
            border: 3px solid rgba(0, 0, 0, 0.8);
        }
        .carousel-control-prev i, .carousel-control-next i {
            font-size: 36px;
            position: absolute;
            top: 50%;
            display: inline-block;
            margin: -19px 0 0 0;
            z-index: 5;
            left: 0;
            right: 0;
            color: rgba(0, 0, 0, 0.8);
            text-shadow: none;
            font-weight: bold;
        }
        .carousel-control-prev i {
            margin-left: -3px;
        }
        .carousel-control-next i {
            margin-right: -3px;
        }
        .carousel-indicators {
            bottom: -50px;
        }
        .carousel-container h1 {
            text-align: center;
            margin-top: 40px;
        }
        .carousel-indicators li, .carousel-indicators li.active {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin: 4px;
            border: none;
        }
        .carousel-indicators li {    
            background: #ababab;
        }
        .carousel-indicators li.active {    
            background: #555;
        }
        .testimonial-container {
            background-color: #f9f9f9;
            padding: 50px 20px;
        }
        .testimonial-container h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        .testimonial-carousel .carousel-item {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }
        .testimonial {
            background: #fff;
            padding: 30px;
            margin: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .testimonial img {
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .testimonial p {
            font-style: italic;
        }
        .testimonial h5 {
            margin-top: 15px;
            font-weight: bold;
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
            BookVault is designed to be your personal assistant in enhancing and tracking your literary journey. Designed by two avid readers, we know your thirsts, and exactly how to quench them.
        </p>
    </section>

    <div class="sign-up">
        <button id="sign-up">Embark</button>
    </div>

    <div class="carousel-container">
        <h1>Why BookVault?</h1>
        <div class="container-xl">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div id="whyBookVaultCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <!-- Carousel indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#whyBookVaultCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#whyBookVaultCarousel" data-slide-to="1"></li>
                            <li data-target="#whyBookVaultCarousel" data-slide-to="2"></li>
                        </ol>   
                        <!-- Wrapper for carousel items -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="img-box"><img src="img/track.jpeg" alt="Track Your Reading"></div>
                                <h4 class="title">Track Your Reading</h4>
                                <p>Keep a record of your reading journey and revisit your favorite books.</p>
                            </div>
                            <div class="carousel-item">
                                <div class="img-box"><img src="img/discover.jpeg" alt="Discover New Books"></div>
                                <h4 class="title">Discover New Books</h4>
                                <p>Get personalized recommendations based on your reading history and preferences.</p>
                            </div>
                            <div class="carousel-item">
                                <div class="img-box"><img src="img/userinterface.jpeg" alt="Join Our Community"></div>
                                <h4 class="title">Our Friendly Use Interface</h4>
                                <p>Dive into the world of literature with the simplest application around</p>
                            </div>
                        </div>
                        <!-- Carousel controls -->
                        <a class="carousel-control-prev" href="#whyBookVaultCarousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="carousel-control-next" href="#whyBookVaultCarousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="testimonial-container">
        <h1>Testimonials</h1>
        <div id="testimonialCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
            <ol class="carousel-indicators">
                <li data-target="#testimonialCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#testimonialCarousel" data-slide-to="1"></li>
                <li data-target="#testimonialCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="testimonial">
                        <img src="img/testimonial1.jpeg" alt="User 1" width="100">
                        <p>"BookVault has transformed my reading habits. The recommendations are spot on!"</p>
                        <h5>- Michael</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="testimonial">
                        <img src="img/testimonial2.jpeg" alt="User 2" width="100">
                        <p>"I love how easy it is to use track my reading progress using the analytics feature. Highly recommend BookVault!"</p>
                        <h5>- John</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="testimonial">
                        <img src="img/testimonial3.jpeg" alt="User 3" width="100">
                        <p>"The discovery feature is amazing. I've cultured my palate in genres and i just can't get enough!"</p>
                        <h5>- Emily</h5>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#testimonialCarousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#testimonialCarousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php include("body/footer.php"); ?>
</body>
</html>
