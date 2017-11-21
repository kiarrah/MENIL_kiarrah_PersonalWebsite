<?php
	session_start();
	require_once('util/util.php');
	require_once('util/connection.php');

	$db = DB::getInstance()->getConnection();
	$query = "SELECT * FROM room_type WHERE id = ${_GET['id']}";
	$result = $db->query($query);
	$roomType = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
	mysqli_free_result($result);

	if (isset($_POST['reservation'])) {

		try {

			$arrival 	= formatDate($_POST['arrival']);
			$departure 	= formatDate($_POST['departure']);
			$rooms 		= explode(",", $_POST['rooms']);
			$firstname 	= $_POST['firstname'];
			$lastname 	= $_POST['lastname'];
			$email 		= $_POST['email'];
			$cardType 	= $_POST['card_type'];
			$cardNumber = $_POST['card_number'];
			$cardMonth 	= $_POST['card_month'];
			$cardYear 	= $_POST['card_year'];
			$cardHolderName = $_POST['card_holder_name'];

			if ($rooms === '') {
				throw new Exception('Please choose your room/s to stay in.');
			} else if ($arrival === '') {
				throw new Exception('Please input ur arrival date.');	
			} else if ($departure === '') {
				throw new Exception('Please input ur departing date');
			}

			$query = "INSERT INTO room_reservation" .
						"(date_start, date_end, firstname, lastname, email, card_type, card_number, card_year, card_month, card_holder_name)" .
						"VALUES" .
						"('${arrival}', '${departure}', '${firstname}', '${lastname}', '${email}', '${cardType}', '${cardNumber}', '${cardYear}', '${cardMonth}', '${cardHolderName}')";

			$db->query($query);
			$reservationId = $db->insert_id;

			$query = "INSERT INTO room_reservation_rooms" .
						"(room_id, room_reservation_id) VALUES ";

			foreach ($rooms as $i => $value) {
				$query .= "(${value}, ${reservationId})";
				if ($i != count($rooms) - 1) {
					$query .= ', ';
				}
			}

			$db->query($query);

			redirect("/payment.php?id=${reservationId}");

		} catch (Exception $e) {

			$error = $e->getMessage();

		}

	}

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
			<!-- The above form looks like this -->
			<form class="reservation" method="POST" action="" enctype="multipart/form-data">

				<div class="row u-text-center form-heading">
					<h4><?php echo $roomType['name']; ?> Reservation</h4>
					<h6>Please fill out all the required field.</h6>
				</div>

				<div class="row section">

					<h5 class="section-title">Rooms</h5>
					<h6></h6>

					<div class="row">
						<div class="six columns">
							<label for="arrival">Arrival</label>
							<input
								id="arrival"
								class="u-full-width"
								data-toggle="datepicker"
								placeholder="Date of your arrival"
								name="arrival"
								type="text" />
						</div>

						<div class="six columns">
							<label for="departure">Departing</label>
							<input
								id="departure"
								class="u-full-width"
								data-toggle="datepicker"
								placeholder="Date of your departing"
								name="departure"
								type="text" />
						</div>
					</div>

					<div class="row">
						<h6></h6>
						<label for="arrival">Available &amp; Unavailable Rooms</label>
						<div id="rooms" room-type-id="<?php echo $_GET['id']; ?>">
							<h6>Choose arrival and departing first to see the available rooms for <?php echo $roomType['name']; ?>.</h6>
						</div>
						<input id="input-rooms" type="text" name="rooms">
					</div>

				</div>

				<div class="row section">

					<h5 class="section-title">Personal Information</h5>
					<h6></h6>

					<div class="row">

						<div class="six columns">
							<label for="first-name">First Name</label>
							<input
								id="first-name"
								class="u-full-width"
								placeholder="Allen"
								name="firstname"
								type="text"
								value="<?php printPost('firstname'); ?>" 
								required>
						</div>

						<div class="six columns">
							<label for="last-name">Last Name</label>
							<input
								id="last-name"
								class="u-full-width"
								placeholder="Danao"
								name="lastname"
								type="text"
								value="<?php printPost('lastname'); ?>"
								required>
						</div>

					</div>

					<div class="row">
						<div class="u-full-width">
							<label for="email">Email Address</label>
							<input
								id="email"
								class="u-full-width"
								placeholder="allendanao@gmail.com"
								name="email"
								type="email"
								value="<?php printPost('email'); ?>"
								required>
						</div>
					</div>

					<div class="row">

						<div class="six columns">
							<label for="mobile">Mobile Number</label>
							<input
								id="mobile"
								class="u-full-width"
								placeholder="+639012345678"
								name="mobile"
								type="text"
								value="<?php printPost('mobile'); ?>"
								required>
						</div>

						<div class="six columns">
							<label for="country">Country of Residence</label>
							<select id="country" class="u-full-width" name="country">
								<?php 
									foreach ($countries as $country) {
										$selected = '';
										if ($country === $_POST['country']) {
											$selected = 'selected="selected"';
										}
										echo "<option ${selected}>${country}</option>";
									}
								?>
								<option>Philippines</option>
								<option>United States</option>
							</select>
						</div>

					</div>

				</div>

				<div class="row section">

					<h5 class="section-title">Card Information</h5>
					<h6></h6>


					<div class="row">

						<div class="six columns">
							<label for="card-holder-name">Cardholder's Name</label>
							<input
								id="card-holder-name"
								class="u-full-width"
								placeholder=""
								name="card_holder_name"
								type="text"
								value="<?php printPost('card_holder_name'); ?>"
								required>
						</div>

						<div class="six columns">
							<label for="card-type">Card Type</label>
							<select id="card-type" class="u-full-width" name="card_type">
								<?php
									foreach ($cardTypes as $value) {
										$selected = '';
										if ($value === $_POST['card_type']) {
											$selected = 'selected="selected"';
										}
										echo "<option ${selected}>${value}</option>";
									}
								?>
							</select>
						</div>

					</div>

					<div class="row">

						<div class="six columns">
							<label for="card_number">Card Number</label>
							<input
								id="card-number"
								class="u-full-width"
								placeholder=""
								name="card_number"
								type="text"
								value="<?php printPost('card_number'); ?>"
								required>
						</div>

						<div class="three columns">
							<label>Expiration</label>

							<div class="row">

								<div class="six columns">
									<input
										class="u-full-width"
										placeholder="MM"
										name="card_month"
										type="text"
										value="<?php printPost('card_month'); ?>" 
										required>
								</div>

								<div class="six columns">
									<input
										class="u-full-width"
										placeholder="YY"
										name="card_year"
										type="text"
										value="<?php printPost('card_year'); ?>" 
										required>
								</div>

							</div>

						</div>

					</div>
					

				</div>

				<div class="row section">

					<h5 class="section-title">Terms &amp; Conditions</h5>
					<h6></h6>
					<h6>All charges are based on local currency. Alternate currency displays are for information purposes only.</h6>

					<label>
					    <input name="agree" type="checkbox">
					    <span class="label-body">I have read and agree to the <a href="#">Terms and Conditions and Data Privacy &amp; Security Policy</a></span>
				  	</label>

				  	<label>
					    <input name="communication" type="checkbox">
					    <span class="label-body">I do not wish to receive e-mail communications about the services and promotions of The Hamit Hotel &amp; Suites</span>
				  	</label>

				  	<div class="row">
				  		<input type="submit" name="reservation" value="Complete Reservation">
				  	</div>

				</div>

			</form>
		</div>

	</div>

	<?php include_once('asset/footer.php'); ?>

</body>
</html>