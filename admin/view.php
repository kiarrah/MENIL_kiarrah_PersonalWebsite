<?php
	
	session_start();
	require_once('../util/util.php');
	require_once('../util/connection.php');

	$db = DB::getInstance()->getConnection();

	if (!isset($_SESSION['account']) && $_SESSION['account']['level'] != 'ADMIN') {

		header("Location: index.php");

	} else if (isset($_FILES['upload'])) {

		$tmpFilePath = $_FILES['upload']['tmp_name'];
		$info = pathinfo($_FILES['upload']['name']);
		$ext = $info['extension'];
		$name = uniqid() . '.' . $ext;

		// Make sure we have a file uploaded
		if ($tmpFilePath != "") {

			//Setup our new file path
			$newFilePath = '../upload/' . $name;

			//Upload the file into the temp dir
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				# Save to db
				$query = "INSERT INTO room_image (file_name, room_type_id) VALUES ('${name}', ${_GET['id']})";
				$db->query($query);
			}

		}

	} else if (isset($_GET['delete_image'])) {

		$query = "SELECT file_name FROM room_image WHERE id = {$_GET['delete_image']}";
		$result = $db->query($query);
		$images = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		
		foreach ($images as $image) {
			unlink("../upload/${image['file_name']}");
		}

		$query = "DELETE FROM room_image WHERE id = ${_GET['delete_image']}";
		$result = $db->query($query);
		$db->query($query);

	}

	$url = url();
	$alertType;
	$alertMsg;
	
	$query 		= "SELECT * FROM room_type WHERE id = {$_GET['id']}";
	$result 	= $db->query($query);
	$roomType 	= mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
	mysqli_free_result($result);

	$query = "SELECT * FROM room_image WHERE room_type_id = {$_GET['id']}";
	$result = $db->query($query);
	$images = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);

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

		<div class="row">

			<div class="col-md-6 offset-md-3 col-sm-12">
				<div class="card">
					<div class="card-body">
						<div class="card-body">
						    <h4 class="card-title"><?php echo $roomType['name']; ?></h4>
						    <p class="card-text"><?php echo $roomType['description']; ?></p>
					  	</div>
					  	<ul class="list-group list-group-flush">
							<li class="list-group-item">
								<div class="row">

									<?php foreach ($images as $image) { ?>
									<div class="col-md-6 col-sm-12">
										<a href="<?php echo "${url}/admin/view.php?id=${roomType['id']}&delete_image=${image['id']}"; ?>" class="room-images">
											<img src="../upload/<?php echo $image['file_name']; ?>" class="img-thumbnail rounded">
										</a>
									</div>
									<?php } ?>

									<div class="col-md-6 col-sm-12">
										<form class="fluid" method="POST" action="" enctype="multipart/form-data">
											<div class="room-add-image file-upload">
											    <i class="material-icons">&#xE145;</i>
										    	<input type="file" name="upload" class="upload-image" />
										    	<input type="submit" class="upload-submit">
											</div>
										</form>
									</div>

								</div>
							</li>
						</ul>
					  	<div class="card-body">
							<a href="<?php echo "${url}/admin/edit.php?id=${roomType['id']}"; ?>" class="card-link">Edit</a>
							<a href="<?php echo "${url}/admin?delete_room_type=${roomType['id']}"; ?>" class="card-link">Delete</a>
						</div>
					</div>
				</div>
			</div>

		</div>

		<h1></h1>

	</div>
	
	<script type="text/javascript" src="<?php pUrl() ?>/js/jquery.js" ></script>
	<script type="text/javascript" src="<?php pUrl() ?>/js/popper.js" ></script>
	<script type="text/javascript" src="<?php pUrl() ?>/js/bootstrap.js"></script>

	<script>

		document.getElementsByClassName('upload-image')[0].onchange = function() {
			document.getElementsByClassName('upload-submit')[0].click();
		};

	</script>

</body>
</html>
<?php $db->close(); ?>