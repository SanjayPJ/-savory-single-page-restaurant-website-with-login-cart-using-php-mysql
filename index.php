<!DOCTYPE HTML>
<!--
	Aesthetic by gettemplates.co
	Twitter: http://twitter.com/gettemplateco
	URL: http://gettemplates.co
-->

<?php

session_start();

if(isset($_GET['state'])){
    if($_GET['state'] == 'logout'){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
    header("Location: index.php");
}
include "includes/connection.php";

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($connection, $_POST['form_email']);
    $password = mysqli_real_escape_string($connection, $_POST['form_password']);
    $query = "SELECT name, password FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $query);
    
    if($result){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $hashedPassword = $row['password'];
        
                if(password_verify($password, $hashedPassword)){
                    $_SESSION['name'] = $row['name'];
                }else{
                    $login_error = "Invalid username or password";
                }
            }
        }else{
            $login_error = "Invalid username or password";
        }
    }else{
        $login_error = mysqli_error($connection);
    }
}
if(isset($_SESSION['name'])){
    if(isset($_GET['rm_id'])){
        $id = $_GET['rm_id'];
        $query = "DELETE FROM cart WHERE id='$id'";
        $result = mysqli_query($connection, $query);
    }
    if(isset($_GET['add_id'])){
        $id = $_GET['add_id'];
        $query = "SELECT * FROM cart WHERE id='$id'";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 0){
            $query_w = "INSERT INTO cart (id, num) VALUES ('$id','1')";
            $result_w = mysqli_query($connection, $query_w);
        }else{
             while($row = mysqli_fetch_assoc($result)){
                 $db_num = $row['num'] + 1;
             }
            $query_w = "UPDATE cart SET num='$db_num' WHERE id='$id'";
            $result_w = mysqli_query($connection, $query_w);
        }
    }
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Savory &mdash; Free Website Template, Free HTML5 Template by GetTemplates.co</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free HTML5 Website Template by GetTemplates.co" />
    <meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
    <meta name="author" content="GetTemplates.co" />

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="css/icomoon.css">
    <!-- Themify Icons-->
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <!-- Bootstrap DateTimePicker -->
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <!-- Theme style  -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Modernizr JS -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

</head>

<body>

    <div class="gtco-loader"></div>

    <div id="page">


        <!-- <div class="page-inner"> -->
        <nav class="gtco-nav" role="navigation">
            <div class="gtco-container">

                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <div id="gtco-logo" style="padding-top: 4px;"><a href="index.html">Savory <em>.</em></a></div>
                    </div>
                    <div class="col-xs-8 text-right menu-1">
                        <ul>
                           
                           <?php 
                            if(isset($_SESSION['name'])){
                                ?>
                                <li><a style="cursor: pointer">Hi, <?php echo $_SESSION['name'];?></a></li>
                                <li class="btn-cta"><a id="cart-btn" href="#cart" style="width:auto;padding: 0;"><span><i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;Cart</span></a></li>
                                <li class="btn-cta"><a href="index.php?state=logout" style="width:auto;
                            padding: 0;"><span><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Log out</span></a></li>
                                <?php
                            }else{
                            ?>
                            <li class="btn-cta"><a href="#" onclick="document.getElementById('id01').style.display='block'" style="width:auto;
                            padding: 0;"><span><i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Log In</span></a></li>
                            <?php 
                            }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>
        <div id="id01" class="modal" style="z-index: 999999">

            <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>

                <div class="container-model">
                    <label for="uname" style="padding-top: 20px;"><b>Email</b></label>
                    <input type="email" class="form-control" placeholder="Enter Email" name="form_email" required>

                    <label for="psw" style="padding-top: 10px;"><b>Password</b></label>
                    <input type="password" class="form-control" placeholder="Enter Password" name="form_password" required>
                    
                    <?php 
                    if(isset($login_error)){
                    ?>

                     <div class="alert" style="background-color: #d9534f;">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <strong>Oops!</strong> <?php echo $login_error; ?>
                    </div>
                   
                    <?php 
                    }
                    ?>

                    <button name="submit" type="submit" class="btn btn-success" style="width: 100%; margin-top: 10px;"><i class="fas fa-sign-in-alt"></i> Login</button>
                </div>

                <div class="container-model" style="background-color:#f1f1f1">
                    <span class="psw">Forgot <a href="#">password?</a></span>
                    <button type="button" class="btn btn-danger" style="width: 100%; margin-top: 10px;" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                </div>
            </form>
        </div>



        <header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="gtco-container">
                <div class="row">
                    <div class="col-md-12 col-md-offset-0 text-left">
                        <div class="row row-mt-15em">
                            <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                                <span class="intro-text-small">Hand-crafted by <a href="http://gettemplates.co" target="_blank">GetTemplates.co</a></span>
                                <h1 class="cursive-font">All in good taste!</h1>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>
        <div class="gtco-section">
            <div class="gtco-container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                        <h2 class="cursive-font primary-color">Popular Dishes</h2>
                        <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                    </div>
                </div>
                <div class="row">
                    
                    <?php 
                    
                    $query = "SELECT * FROM dishes";
                    $result = mysqli_query($connection, $query);
                    if($result){
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $id = $row['id'];
                                $name = $row['name'];
                                $des = $row['des'];
                                $img = $row['img'];
                                $price = $row['price'];
                                $item = '<div class="col-lg-4 col-md-4 col-sm-6 purchased_card">
                                            <a class="fh5co-card-item image-popup lap-cont" href="index.php?add_id=' . $id . '">
                                            <figure>
                                                <div class="overlay"><i class="ti-plus"></i></div>
                                                <img src="' . $img .'" alt="Image" class="img-responsive">
                                            </figure>
                                            <div class="fh5co-text">
                                                <h2>'. $name .'</h2>
                                                <p>'. $des .'</p>
                                                <p><span class="price cursive-font">$'. $price .'</span></p>
                                            </div>
                                        </a>
                                        </div>';
                                echo $item;
                            }
                        }else{
                            $db_error = "No data in database!";
                        }
                    }else{
                        echo mysqli_error($connection);
                    }
                    
                    ?>
                </div>
            </div>
        </div>
        <!--        cart starts here-->
        <?php 
        if(isset($_SESSION['name'])){
        ?>

        <div class="gtco-section" style="background-color: rgba(255, 248, 230, 0.6)" id="cart">
            <div class="gtco-container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                        <h2 class="cursive-font primary-color">Shopping Cart</h2>
                        <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                    </div>
                </div>

                <div class="row">
<!--                   validating-->
                 <?php 
                if(isset($_GET['add_id']))   {
                ?>
                   <div class="alert" style="background-color:#6bbd6e; margin : 0 14px 20px 14px;">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <strong>Yea, </strong><?php echo "Item added to the cart"; ?>
                    </div>
                    <?php
                }
                    ?>
                    <?php 
                if(isset($_GET['rm_id']))   {
                ?>
                   <div class="alert" style="background-color:#f44336; margin : 0 14px 20px 14px;">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <strong>Yea, </strong><?php echo "Item removed from the cart"; ?>
                    </div>
                    <?php
                }
                    ?>
                    
                    
                  <?php 
                    $query = "SELECT * FROM cart";
                    $result = mysqli_query($connection, $query);
                    $totalPrice = 0;
                    if($result){
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $id = $row['id'];
                                $num = $row['num'];
                                $query = "SELECT * FROM dishes WHERE id='$id'";
                                $result_s = mysqli_query($connection, $query);
                                if($result_s){
                                    if(mysqli_num_rows($result_s) > 0){
                                        while($row = mysqli_fetch_assoc($result_s)){
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $des = $row['des'];
                                            $img = $row['img'];
                                            $price = $row['price'];
                                            $item = '<div class="col-lg-6 col-md-6 col-sm-12">
                                                        <button class="fh5co-card-item image-popup all-item">
                                                            <div class="row">
                                                             <a href="index.php?rm_id=' . $id . '"><span class="close" style="font-size: 15px;"><i class="fas fa-times"></i></span></a>
                                                              <div class="col-lg-6 col-md-6 col-sm-12">
                                                               <img src="'. $img .'" alt="Image" style="width: 112%;">
                                                                </div>
                                                               <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="fh5co-text" style="padding-top: 30px;">
                                                                        <h2>'.$name.'</h2>
                                                                        <p style="padding-left: 10px; font-size: 14px">'.$des.'</p>
                                                                        <h2>$'.$price.' x '.$num.' = $'.$price*$num.'</h2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </div>';
                                            
                                            echo $item;
                                            $totalPrice += $price*$num;
                                        }
                                    }else{
                                        $cart_error = "Your Shopping Cart is empty.";
                                    }
                                }else{
                                    echo mysqli_error($connection);
                                }
                                
                            }
                        }else{
                            $cart_error = "Your Shopping Cart is empty.";
                        }
                    }else{
                        $cart_error ="Your Shopping Cart is empty." . mysqli_error($connection);
                    }
                    ?>
                    
                    <!--                alert-->

                    
                    
              <?php 
                if(isset($cart_error)){
                ?>
                 <div class="alert">
                  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                  <strong>Oops!</strong> <?php echo $cart_error; ?>
                </div>
                  
                <?php  
                    
                }
                
                ?>
               
                   
                </div>
                    <?php
                    if($totalPrice > 0){
                    ?>
                     
                     <div>
                     <h1 class="cursive-font primary-color" style=" margin-top: 20px;text-align:right;">Subtotal $<?php echo $totalPrice; ?></h1>
                     <div  style="text-align:right;"><button class="btn warning"><span style=" font-family: 'Kaushan Script';">Proceed to Checkout</span></button></div>
                     </div>
                    <?php
                    }

                    ?>
            </div>
        </div>
        
        <?php 
        }
        ?>

        <!--        cart ends here-->


        <div id="gtco-features">
            <div class="gtco-container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
                        <h2 class="cursive-font">Our Services</h2>
                        <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="feature-center animate-box" data-animate-effect="fadeIn">
                            <span class="icon">
							<i class="ti-face-smile"></i>
						</span>
                            <h3>Happy People</h3>
                            <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="feature-center animate-box" data-animate-effect="fadeIn">
                            <span class="icon">
							<i class="ti-thought"></i>
						</span>
                            <h3>Creative Culinary</h3>
                            <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="feature-center animate-box" data-animate-effect="fadeIn">
                            <span class="icon">
							<i class="ti-truck"></i>
						</span>
                            <h3>Food Delivery</h3>
                            <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <div class="gtco-cover gtco-cover-sm" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="gtco-container text-center">
                <div class="display-t">
                    <div class="display-tc">
                        <h1>&ldquo;Their high quality of service makes me back over and over again!&rdquo;</h1>
                        <p>&mdash; John Doe, CEO of XYZ Co.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="gtco-counter" class="gtco-section">
            <div class="gtco-container">

                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
                        <h2 class="cursive-font primary-color">Fun Facts</h2>
                        <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="feature-center">
                            <span class="counter js-counter" data-from="0" data-to="5" data-speed="5000" data-refresh-interval="50">1</span>
                            <span class="counter-label">Avg. Rating</span>

                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="feature-center">
                            <span class="counter js-counter" data-from="0" data-to="43" data-speed="5000" data-refresh-interval="50">1</span>
                            <span class="counter-label">Food Types</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="feature-center">
                            <span class="counter js-counter" data-from="0" data-to="32" data-speed="5000" data-refresh-interval="50">1</span>
                            <span class="counter-label">Chef Cook</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                        <div class="feature-center">
                            <span class="counter js-counter" data-from="0" data-to="1985" data-speed="5000" data-refresh-interval="50">1</span>
                            <span class="counter-label">Year Started</span>

                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div id="gtco-subscribe">
            <div class="gtco-container">
                <div class="row animate-box">
                    <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                        <h2 class="cursive-font">Subscribe</h2>
                        <p>Be the first to know about the new templates.</p>
                    </div>
                </div>
                <div class="row animate-box">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Your Email">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <button class="btn btn-default btn-block">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer id="gtco-footer" role="contentinfo" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.9">
            <div class="overlay"></div>
            <div class="gtco-container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="gtco-widget">
                            <h3>Get In Touch</h3>
                            <ul class="gtco-quick-contact">
                                <li><a href="#"><i class="icon-phone"></i> +1 234 567 890</a></li>
                                <li><a href="#"><i class="icon-mail2"></i> info@GetTemplates.co</a></li>
                                <li><a href="#"><i class="icon-chat"></i> Live Chat</a></li>
                            </ul>
                        </div>
                        <div class="gtco-widget">
                            <h3>Get Social</h3>
                            <ul class="gtco-social-icons">
                                <li><a href="#"><i class="icon-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-linkedin"></i></a></li>
                                <li><a href="#"><i class="icon-dribbble"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-12 text-center copyright">
                        <p><small class="block">&copy; 2016 Free HTML5. All Rights Reserved.</small>
                            <small class="block">Designed by <a href="http://gettemplates.co/" target="_blank">GetTemplates.co</a> Demo Images: <a href="http://unsplash.com/" target="_blank">Unsplash</a></small></p>
                    </div>

                </div>
            </div>
        </footer>
        <!-- </div> -->

    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- jQuery Easing -->
    <script src="js/jquery.easing.1.3.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Waypoints -->
    <script src="js/jquery.waypoints.min.js"></script>
    <!-- Carousel -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- countTo -->
    <script src="js/jquery.countTo.js"></script>

    <!-- Stellar Parallax -->
    <script src="js/jquery.stellar.min.js"></script>

    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>


    <!-- Main -->
    <script src="js/main.js"></script>

    <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        $("#cart-btn").click(function() {
            $('html, body').animate({
                scrollTop: $("#cart").offset().top
            }, 1000);
        });

    </script>

</body>

</html>
