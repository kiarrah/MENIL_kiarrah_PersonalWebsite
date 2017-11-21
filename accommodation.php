<?php
	session_start();
	require_once('util/util.php');
	require_once('util/connection.php');

	$db = DB::getInstance()->getConnection();
	$url = url();

	$query = "SELECT room_type.*, room_image.* FROM room_type LEFT JOIN room_image ON room_type.id = room_image.room_type_id GROUP BY room_type.id";

	$result = $db->query($query);
	$roomTypes = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);

?>
<!DOCTYPE html>
<html>
<head>

	<title>Hamit Hotel</title>
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/skeleton.css">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="css/social.icons.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

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

			<?php

			if (isset($_GET['id'])) {

				$query = "SELECT * FROM room_type WHERE id = ${_GET['id']}";
				$result = $db->query($query);
				$roomType = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
				mysqli_free_result($result);

				$query = "SELECT * FROM room_image WHERE room_type_id = ${_GET['id']}";
				$result = $db->query($query);
				$images = mysqli_fetch_all($result, MYSQLI_ASSOC);
				mysqli_free_result($result);

			?>

			<div class="two columns side-nav">
				<ul>
					<li>
						Rooms &amp; Suites
						<ul>

							<?php

							foreach ($roomTypes as $roomType) {
								echo "<li><a href=\"${url}/accommodation.php?id=${roomType['id']}\">${roomType['name']}</a></li>";
							}

							?>

						</ul>
					</li>
				</ul>
			</div>

			<div class="ten columns accommodation">

				<div class="title">
					<h5>HAMIT HOTEL &amp; SUITES</h5>
					<h3><?php echo $roomType['name']; ?></h3>
					<hr />
				</div>

				<div class="body">

					<?php if (count($images) > 0): ?>

						<div class="carousel owl-carousel owl-theme">
							<?php foreach ($images as $key => $image) {
								echo "<img class=\"owl-lazy\" data-src=\"upload/${image['file_name']}\">";
							} ?>
						</div>

					<?php endif; ?>

					
					<div class="row">
						
						<div class="four columns">
							<div class="reservation">
								<h4 class="title">Reservation</h4>
								<span>Rate: PHP <?php echo number_format($roomType['rate']); ?></span>
								<a class="button" href="<?php echo "${url}/reservation.php?id=${roomType['id']}"; ?>">Check Availability</a>
							</div>
						</div>
						<div class="eight columns">
							<div class="room-type-description"><?php echo $roomType['description']; ?></div>
						</div>
					</div>

				</div>
			
			</div>

			<?php } else { ?>

			<h1></h1>

			<div class="intro">
				<h5>HAMIT HOTEL &amp; SUITES</h5>
				<p>With an accent on classic modernity, which adheres to the design tenets of simplicity and chic elegance, the new rooms showcase the finest materials and craftsmanship.</p>
				<hr />
			</div>

			<?php 

			$i = 0;

			foreach ($roomTypes as $roomType) {
				
				if ($i % 2 == 0) {
					echo '<div class="row">';
				}

				?>

				<div class="six columns">
					<div class="image-box">
						<img src="upload/<?php echo $roomType['file_name']; ?>">
						<div class="middle">
							<div class="title"><?php echo $roomType['name']; ?></div>
							<div class="description"><?php echo $roomType['description']; ?></div>
							<a class="link" href="<?php echo "${url}/accommodation.php?id=${roomType['id']}"; ?>">SEE ROOM</a>
						</div>
					</div>
				</div>

				<?php

				if ($i % 2 == 0) {
					echo '</div>';
				}

				$i++;
			}

			?>
			
			<h1></h1>

			<?php } ?>

		</div>
	</div>

	<?php include_once('asset/footer.php'); ?>

</body>
</html>