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
            height: 70px;
        }
        .logo {
            height: 65px;
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
        .p2 {
            margin-left: 200px;
        }
        .content h2 {
            margin-bottom: 200px;   
            text-align: center;
        }
        .sign-up {
            display: flex;
            justify-content: center;
            padding: 20px;
            margin-top: 3%;
          
        }
        .sign-up button {
            background-color: green;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .sign-up button:hover {
            background-color: darkgreen;
          
        }
          .Intro {
            position: relative;
            background: url('img/vaultimg.png') no-repeat center center/cover;
            height: 75vh;
            color: white;
            text-align: left;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .Intro .content {
            width: 80%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .Intro h1 {
            font-size: 3em;
            margin-bottom: 200px;
        }
        .paragraph-container {
            display: flex;
            width: 100%;
            justify-content: space-between;
            margin-bottom: 150px;
          
        }
        .paragraph-container .left {
            font-size: 2em;
            line-height: 1.5;
            width: 45%;
            text-align: left;
        }
        .paragraph-container .right {
            font-size: 2em;
            line-height: 1.5;
            width: 45%;
            text-align: right;
            margin-left: 50px;
        }
        .about-us {
            padding: 50px 20px;
            text-align: center;
            margin-top: 40px;
            background-color: #f9f9f9;
            border-radius: round;
        }
        .about-us h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .about-us p {
            font-size: 1.2em;
            line-height: 1.5;
        }
        #search-button {
    background-color: #808080;
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s;
}

#search-button:hover {
    background-color: #a6a6a6;
}

    </style>
</head>
<body>
    <div class="header">
        <img src="img/book-vault-logo.png" alt="Book Vault" class="logo">
        <ul class="menu">
            <li class="suggest">
                <button id="search-button">
                    <i class="fas fa-search"></i> Search Book
                </button>
            </li>
        </ul>
        <div class="header-buttons">
            <button type="button" id="Discover">Discover</button>
            <button type="button" id="login">Log In</button>
        </div>
    </div>

    <section class="Intro">
        <div class="content">
            <div class="paragraph-container">
                <p class="left">
                    Discover a world of books
                    <br> at your fingertips
                </p>
                <p class="right">
                    Join us in making your literary journey
                     one for the books!
                </p>
            </div>
            <div class="sign-up">
        <button id="sign-up">JOIN NOW!!</button>
         </div>
        </div>
        
        
    </section>
   
    <div class="about-us">
        <h1 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">About Us</h1>
        <p style="border-radius: 20px; padding: 20px; background-color: #f9f9f9;">
        BookVault is designed to be your personal assistant in enhancing and tracking your literary journey. Founded by two avid readers with a deep passion for literature, we understand the joys and challenges that come with a love for books. We created BookVault to quench the thirst for knowledge and adventure that every reader possesses. Our platform is built to cater to every aspect of your reading life.
        </p>
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
   <script>
        document.getElementById("Discover").addEventListener("click", function() {
            window.location.href = "discover.php";
        });
        document.getElementById("login").addEventListener("click", function() {
            window.location.href = "choice.html";
        });
        document.getElementById("search-button").addEventListener("click", function() {
            window.location.href = "search.php";
        });
        document.getElementById("sign-up").addEventListener("click", function() {
            window.location.href = "usersignup.html";
        });
    </script>
    <?php include("body/footer.php"); ?>
</body>
</html>
