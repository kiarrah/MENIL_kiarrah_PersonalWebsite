<?php
	session_start();
	require_once('util/util.php');
	require_once('util/connection.php');

	$db = DB::getInstance()->getConnection();

	$query = "SELECT * FROM room_reservation WHERE id = ${_GET['id']}";
	$result = $db->query($query);
	$reservation = $result->fetch_assoc();
	mysqli_free_result($result);

	$query = "SELECT room.number, room.room_type_id FROM room_reservation_rooms LEFT JOIN room ON room.id = room_reservation_rooms.room_id WHERE room_reservation_rooms.room_reservation_id = ${_GET['id']} GROUP BY room.number";
	$result = $db->query($query);
	$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);

	$roomTypeId = $rooms[0]['room_type_id'];

	$query = "SELECT * FROM room_type WHERE id = ${roomTypeId}";
	$result = $db->query($query);
	$roomType = $result->fetch_assoc();
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
	<link rel="stylesheet" type="text/css" href="css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/social.icons.css">
	<link rel="stylesheet" type="text/css" type="text/css" href="css/style.css">

</head>
<body>

	<nav>
		<img class="logo" src="<?php pUrl() ?>/asset/logo.png">
		<ul>
			<li><a href="<?php pUrl(); ?>/">HOME</a></li>
			<li><a href="#">ABOUT US</a></li>
			<li><a href="<?php pUrl(); ?>/accommodation.php">ACCOMMODATIONS</a></li>
		</ul>
	</nav>

	<div class="banner">
		<img src="asset/banner.jpg">
	</div>

	<div class="container">
		<div class="row">

			<div class="eight columns">
				
				<div class="success-card">
					<div class="header">
						<div class="middle">
							<i class="material-icons check">&#xE5CA;</i>
							<div class="msg">SUCCESS</div>
						</div>
					</div>
					<div class="body">
						Congratulations your room reservation/booking has been successfully created.
						<a href="<?php pUrl(); ?>/accommodation.php" class="button">Go Back</a>
					</div>
				</div>

			</div>

			<div class="four columns">
				<div id="summary">
					<div class="header">
						<h5>BOOKING SUMMARY</h5>
						<div>Hamit Hotel &amp; Suites</div>
						<hr />
					</div>
					<div class="body">
						<div class="section">Reservation Details</div>
						<div><?php echo $roomType['name']; ?></div>
						<div>Room 
							<?php foreach ($rooms as $value) {
								echo "#${value['number']}";
							} ?>
						</div>

						<div>
							<?php 

								$dateArrival = date('l, d F', strtotime($reservation['date_start']));
								$dateDeparture = date('l, d F', strtotime($reservation['date_end']));

								echo "${dateArrival} - ${dateDeparture}";

							?>
						</div>

						<div>
							<?php 

								$start = strtotime($reservation['date_start']); // or your date as well
								$end = strtotime($reservation['date_end']);
								$datediff = $end - $start;
								$days = floor($datediff / (60 * 60 * 24));
								$nights = $days - 1;

								echo "${days} Days (${nights} Nights)";

							?>
						</div>

						<div class="section">Room Rate</div>

						<div class="section-compute">
							<?php

								$dateArrival = new DateTime($reservation['date_start']);
								$roomCount = count($rooms);
								$subtotal = 0;

								for ($i = 0; $i < $days; $i++) {
									$str = $dateArrival->format('d F');
									$subtotal += $roomType['rate'];
									$rate = number_format($roomType['rate']);
									echo "<span class=\"u-pull-left\">${str}</span>&nbsp;<span class=\"u-pull-right\">PHP ${rate}</span><br />";
									$dateArrival->modify('+1 day');
								}

								$subtotal *= $roomCount;
								echo "<span class=\"u-pull-left\">Room count</span>&nbsp;<span class=\"u-pull-right\">x${roomCount}</span><br />";

								$total = $subtotal;
								?>
						</div>

						<hr />

						<div class="section-subtotal">
							<span class="u-pull-left">SUB TOTAL:*</span>
							&nbsp;
							<span class="u-pull-right">PHP <?php echo number_format($subtotal); ?></span>
						</div>

						<div class="tax-msg">*Tax not included (10 Percent) service charge per room per night</div>

						<hr />

						<div class="total">
							<strong class="u-pull-left">TOTAL:</strong>
							&nbsp;
							<strong class="u-pull-right">PHP <?php echo number_format($total); ?></strong>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>
	<?php include_once('asset/footer.php'); ?>

</body>
</html>