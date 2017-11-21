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
					<h4>WELCOME</h4>
					<h6>Welcome to our luxury and romantic Bed and Breakfast on beautiful Mount Apo.</h6>
				</div>
				<div class="body">
					<hr />
					Hamit Hotel offers luxury 4 Star Bed &amp; Breakfast accommodation with breathtaking views. We are located on the highest mountain &amp; volcano in the Philippines. Escape from the frantic pace of life at work and home, come on up to our cool “island in the sky” and leave your worries behind. Our warm and friendly hospitality will leave you feeling truly welcomed.
					<hr />
				</div>
			</div>
		</div>
	</div>

	<?php include_once('asset/footer.php'); ?>

</body>
</html>