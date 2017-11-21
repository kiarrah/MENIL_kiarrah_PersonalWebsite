<?php
	session_start();
	require_once('util/util.php');
	require_once('util/connection.php');
?>
<!DOCTYPE html>
<html>
<head>

	<title>Hamit Hotel</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/skeleton.css">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/social.icons.css">
	<link rel="stylesheet" type="text/css" type="text/css" href="css/style.css">

</head>
<body>

	<nav>
		<img class="logo" src="<?php pUrl() ?>/asset/logo.png">
		<ul>
			<li><a href="<?php pUrl(); ?>/">HOME</a></li>
			<li><a href="<?php pUrl(); ?>/about-us.php">ABOUT US</a></li>
			<li><a href="<?php pUrl(); ?>/accommodation.php">ACCOMMODATIONS</a></li>
		</ul>
	</nav>

	<div class="banner">
		<img src="asset/banner.jpg">
	</div>

	<div class="container">
		<div class="row">
			<div class="snippet-about">
				<div class="head">
					<h4>WELCOME TO HAMIT HOTEL</h4>
					<h6>Welcome to our luxury and romantic Bed and Breakfast on beautiful Mount Apo.</h6>
				</div>
				<div class="body">
					<hr />
					At Hamit, our passion is to connect our guests to the very best of our destinations. From the beaches of Hawaii and Bermuda to the deserts of the United Arab Emirates to the heart of London, our hotel offer guests extraordinary places, created by combining unique architecture and structure, expressive decor and artistry, and magnificent features. Add great service, and the result is an unforgettable guest experience. We’re proud to welcome you to our collection, which includes some of the most iconic hotels in the world. We invite you to think of Hamit Hotel as your home base for all of your adventures.
					</br> </br>
					Make Hamit your personal gateway to exploring the world’s most extraordinary places—and to having your most memorable experiences.
					</br> </br>
					So, what are you waiting for come and book now!
					<hr />
				</div>
			</div>
		</div>
	</div>

	<?php include_once('asset/footer.php'); ?>

</body>
</html>