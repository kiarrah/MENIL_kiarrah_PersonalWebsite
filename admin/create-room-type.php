<?php
	
	session_start();
	require_once('../util/util.php');
	require_once('../util/connection.php');

	$db = DB::getInstance()->getConnection();
	$alertType = "";
	$alertMsg = "";
	
	if (isset($_POST['create-room-type'])) {

		try {

			$roomTypeId;
			
			$roomType 		= $db->real_escape_string($_POST['room-type-new']);
			$roomDescription = $db->real_escape_string($_POST['room-description']);
			$roomRate 		= $db->real_escape_string($_POST['room-rate']);
			$fileCount 		= count($_FILES['upload']['name']);

			// Check if no images
			if ($_FILES['upload']['name'][0] === '') {
				throw new Exception('There are no image/s to upload.');
			}

			if (isset($roomType) && isset($roomDescription)) {

				$query = "INSERT INTO room_type (name, description, rate) VALUES ('${roomType}', '${roomDescription}', ${roomRate})";
				$db->query($query);
				$roomTypeId = $db->insert_id;

			} else {
				throw new Exception('Please fill up all the required fields');
			}

			// Loop through each file
			for($i=0; $i < $fileCount; $i++) {

				//Get the temp file path
				$tmpFilePath = $_FILES['upload']['tmp_name'][$i];

				$info = pathinfo($_FILES['upload']['name'][$i]);
				$ext = $info['extension'];
				$name = uniqid() . '.' . $ext;

				//Make sure we have a filepath
				if ($tmpFilePath != "") {

					//Setup our new file path
					$newFilePath = '../upload/' . $name;

					//Upload the file into the temp dir
					if(move_uploaded_file($tmpFilePath, $newFilePath)) {

					  $query = "INSERT INTO room_image (file_name, room_type_id) VALUES ('$name', $roomTypeId)";
					  $db->query($query);

					}

				}

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

			<div class="col-md-6 offset-md-3 col-sm-12">
				<div class="card">

					<div class="card-header">
					    <h4 class="card-title">Create A Room Type</h4>
						<h6 class="card-subtitle mb-2 text-muted">Add any room type here like Superior or Deluxe rooms. Your choice.</h6>
					</div>

					<form class="card-body" method="POST" action="" enctype="multipart/form-data">

						<div class="form-group">
							<label for="room-type-new">New Room Type</label>
							<input type="text" class="form-control" id="room-type-new" name="room-type-new" aria-describedby="room-type-new" placeholder="Enter room type name">
							<small id="room-type-new" class="form-text text-muted">Atchup nga room type.</small>	
						</div>

						<div class="form-group">
							<label for="room-description">Description</label>
							<textarea name="room-description" class="form-control" id="room-description" rows="3"></textarea>
						</div>

						<div class="form-group">
							<label for="room-rate">Room Rate</label>
							<input type="number" class="form-control" id="room-rate" name="room-rate" aria-describedby="emailHelp" placeholder="Enter room rate" required="">
						</div>

						<div class="form-group">
							<label for="room-images">Room Photos</label>
							<input type="file" name="upload[]" class="form-control-file" id="room-images" multiple="multiple">
						</div>

						<button name="create-room-type" type="submit" class="btn btn-primary">Submit</button>

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