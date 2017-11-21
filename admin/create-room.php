<?php
	
	session_start();
	require_once('../util/util.php');
	require_once('../util/connection.php');

	$db = DB::getInstance()->getConnection();
	$alertType = '';
	$alertMsg = '';
	$db;
	
	if (isset($_POST['create-room'])) {

		try {

			$roomTypeId;
			
			$roomType 		= $db->real_escape_string($_POST['room-type']);
			$roomNumber 	= $db->real_escape_string($_POST['room-number']);

			if (isset($roomType) && isset($roomNumber)) {

				$query = "INSERT INTO room (room_type_id, number) VALUES (${roomType}, ${roomNumber})";
				$db->query($query);
				$roomTypeId = $db->insert_id;

			} else {
				throw new Exception('Please fill up all the required fields');
			}

			$alertType = 'success';
			$alertMsg = 'Create room success!';

		} catch (Exception $e) {

			$alertType = 'danger';
			$alertMsg = $e->getMessage();

		}

	}
	
	if (!isset($_SESSION['account']) && $_SESSION['account']['level'] != 'ADMIN') {
		header("Location: index.php");
	}

?>
<!DOCTYPE html>
<html>
<head>

	<title>Admin</title>

	<link rel="stylesheet" type="text/css" href="<?php pUrl() ?>/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php pUrl() ?>/css/admin.css">

</head>
<body>

	<div id="bg" class="blue"></div>

	<nav class="navbar navbar-expand-lg navbar-dark">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="<?php pUrl() ?>/admin">Back to Accommodation</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php pUrl() ?>/logout.php">Logout</a>
			</li>
		</ul>
	</nav>

	<div class="container">

		<div class="section"></div>
		
		<? if (isset($alertType)): ?>

			<div class="alert alert-<?php echo $alertType; ?>" role="alert">
			  <?php echo $alertMsg; ?>
			</div>

		<? endif; ?>

		<div class="row">

			<div class="col-md-4 offset-md-4 col-sm-12">
				
				<div class="card">

					<form class="card-body" method="POST" action="" enctype="multipart/form-data">

						<h4 class="card-title">Create Room</h4>
						<h6 class="card-subtitle mb-2 text-muted">Add room in a room type.</h6>

						<div class="form-group">
						<label for="room-type">Room Type</label>
						<select name="room-type" class="form-control" id="room-type">

						<?php

							$db = DB::getInstance()->getConnection();
							$query = "SELECT * FROM room_type";
							$id = $_GET['id'];

							if ($result = $db->query($query)) {
								while ($room = $result->fetch_assoc()) {
									if ($room['id'] == $_GET['id']) {
										echo '<option value="'.$room['id'].'" selected>'.$room['name'].'</option>';
									} else {
										echo '<option value="'.$room['id'].'">'.$room['name'].'</option>';
									}
									
								}
							}

						?>
						</select>
						</div>

						<div class="form-group">
							<label for="room-number">Room #</label>
							<input type="number" class="form-control" id="room-number" name="room-number" aria-describedby="emailHelp" placeholder="Enter room number" required="">
						</div>

						<button name="create-room" type="submit" class="btn btn-primary">Submit</button>

					</form>
				</div>

			</div>

		</div>
			
		<h1></h1>

	</div>
	
	<script type="text/javascript" src="<?php pUrl() ?>/js/jquery.js" ></script>
	<script type="text/javascript" src="<?php pUrl() ?>/js/popper.js" ></script>
	<script type="text/javascript" src="<?php pUrl() ?>/js/bootstrap.js"></script>

</body>
</html>
<?php $db->close(); ?>