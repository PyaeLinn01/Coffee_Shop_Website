<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="home.php">home</a> / about </p>
</section>


<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/coffee1about.jpeg" alt="">
        </div>

        <div class="content">
            <h3>why choose Espresso ButterCup?</h3>
            <p>At Espresso ButterCup, we offer freshly brewed coffee, homemade treats, and a cozy atmosphere perfect for both quick stops and leisurely visits. Enjoy friendly service and a warm environment that makes every visit special. Great coffee, great company—choose Espresso Munchies!</p>
            <a href="shop.php" class="btn">Order now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>what we provide?</h3>
            <p>At Espresso ButterCup, we provide Freshly Brewed Coffee and Friendly Service,experiencing exceptional service with a smile.
</p>
            <a href="contact.php" class="btn">contact us</a>
        </div>

        <div class="image">
            <img src="images/coffee2about.jpeg" alt="">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/coffee3about.jpeg" alt="">
        </div>

        <div class="content">
            <h3>who we are?</h3>
            <p>Espresso ButterCup is a cozy cafe dedicated to providing freshly brewed coffee and homemade treats. Our friendly staff and inviting atmosphere make us the perfect spot for a quick espresso or a leisurely catch-up with friends. Great coffee, great company—choose Espresso Munchies!</p>
            <a href="#reviews" class="btn">clients reviews</a>
        </div>

    </div>

</section>

<section class="reviews" id="reviews">

    <h1 class="title">customer's reviews</h1>

    <div class="box-container">

        <div class="box">
            <img src="images/pic-1.jpeg" alt="">
            <p>"Best coffee in town! Always fresh and delicious
                Love to come again."
            </p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Winter J</h3>
        </div>

        <div class="box">
            <img src="images/pic-2.jpeg" alt="">
            <p>"Love the cozy vibe and friendly staff. A great place to relax."</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Anna M</h3>
        </div>

        <div class="box">
            <img src="images/pic-3.jpeg" alt="">
            <p>"Amazing espresso and great service every time.
                My favorite go to place"</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Kevin J</h3>
        </div>

        <div class="box">
            <img src="images/pic-4.jpeg" alt="">
            <p>"Espresso ButterCup never disappoints. Consistently great coffee!"</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Ellie K</h3>
        </div>

        <div class="box">
            <img src="images/pic-5.jpeg" alt="">
            <p>"A gem of a cafe! The atmosphere is warm and inviting."</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Ronal M</h3>
        </div>

        <div class="box">
            <img src="images/pic-6.jpeg" alt="">
            <p>"My go-to spot for a quality coffee break. Highly recommend!"</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Yura K</h3>
        </div>

    </div>

</section>











<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>