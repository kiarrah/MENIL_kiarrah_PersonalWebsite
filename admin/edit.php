<?php
	
	session_start();
	require_once('../util/util.php');
	require_once('../util/connection.php');

	if (!isset($_SESSION['account']) && $_SESSION['account']['level'] != 'ADMIN') {
		header("Location: index.php");
	}

	$db = DB::getInstance()->getConnection();
	$alertType = "";
	$alertMsg = "";
	
	if (isset($_POST['edit-room-type'])) {

		try {
			
			$name 			= $db->real_escape_string($_POST['name']);
			$description 	= $db->real_escape_string($_POST['description']);
			$rate 			= $db->real_escape_string($_POST['rate']);

			if (isset($name) && isset($description)) {

				$query = "UPDATE room_type SET name='${name}', description = '${description}', rate = ${rate} WHERE id = {$_GET['id']}";
				$db->query($query);

			} else {
				throw new Exception('Please fill up all the required fields');
			}

			$alertType = 'success';
			$alertMsg = 'Edit room success!';

		} catch (Exception $e) {

			$alertType = 'danger';
			$alertMsg = $e->getMessage();

		}

	}

	$query 		= "SELECT * FROM room_type WHERE id = {$_GET['id']}";
	$result 	= $db->query($query);
	$roomType 	= mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
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
				<a class="nav-link" href="<?php pUrl() ?>/admin/view.php?id=<?php echo $roomType['id']; ?>">Back to <?php echo $roomType['name']; ?></a>
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

					<form class="card-body" method="POST" action="" enctype="multipart/form-data">

						<h4 class="card-title"><?php echo $roomType['name']; ?></h4>

						<div class="form-group">
							<label for="name">Room Type</label>
							<input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter room type" value="<?php echo $roomType['name']; ?>">
							<small id="name" class="form-text text-muted">Atchup nga room type.</small>	
						</div>

						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" class="form-control" id="description" rows="3"><?php echo $roomType['description']; ?></textarea>
						</div>

						<div class="form-group">
							<label for="rate">Room Rate</label>
							<input type="number" class="form-control" id="rate" name="rate" aria-describedby="emailHelp" placeholder="Enter room rate" required="" value="<?php echo $roomType['rate']; ?>">
						</div>

						<button name="edit-room-type" type="submit" class="btn btn-primary">Submit</button>

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