<?php
	
	session_start();
	require_once('../util/util.php');
	require_once('../util/connection.php');

	$db = DB::getInstance()->getConnection();

	if (!isset($_SESSION['account']) && $_SESSION['account']['level'] != 'ADMIN') {
		header("Location: index.php");
	}

	if (isset($_GET['delete_room'])) {

		$query = "DELETE FROM room WHERE id = ${_GET['delete_room']}";
		$db->query($query);

	} else if (isset($_GET['delete_room_type'])) {

		// 1 Delete images.
		$query = "SELECT file_name FROM room_image WHERE room_type_id = {$_GET['delete_room_type']}";
		$result = $db->query($query);
		$images = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);

		foreach ($images as $image) {
			unlink("../upload/${image['file_name']}");
		}

		// 2 Delete the room type
		$query = "DELETE FROM room_type WHERE id = ${_GET['delete_room_type']}";
		$result = $db->query($query);
		$db->query($query);

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
				<a class="nav-link" href="<?php pUrl() ?>/">Go to site</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php pUrl() ?>/logout.php">Logout</a>
			</li>
		</ul>
	</nav>
	
	<div class="container">
		
		<div class="section"></div>

		<div class="row">

			<?php

			$query = "SELECT id, name FROM room_type";
			$result = $db->query($query);
			$roomTypes = mysqli_fetch_all($result, MYSQLI_ASSOC);
			mysqli_free_result($result);

			foreach ($roomTypes as $type) {

				$query = "SELECT id, number FROM room WHERE room_type_id = ${type['id']}";
				$result = $db->query($query);
				$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

				?>

				<div class="col-md-4 col-sm-12">
					<div class="rooms">
					    <div class="rooms-header">

					    	<?php
					    	$url = url();
					    	foreach ($rooms as $room) {
					    		echo "<a href=\"${url}/admin?delete_room=${room['id']}\" class=\"room\">${room['number']}</a>";	
					    	}
					    	?>

					    	<div class="room add">
					    		&nbsp;
					    		<a href="<?php pUrl() ?>/admin/create-room.php?id=<?php echo $type['id']; ?>" class="material-icons">
					    			<i class="material-icons">&#xE145;</i>
					    		</a>
					    	</div>

					    </div>

					    <div class="rooms-body">
					    	<?php echo $type['name'] ?>
					    	<a class="right-2" href="<?php echo "${url}/admin/view.php?id=${type['id']}"; ?>">
					    		<i class="material-icons">&#xE8A0;</i>
					    	</a>
					    	<a class="right" href="<?php echo "${url}/admin?delete_room_type=${type['id']}"; ?>">
					    		<i class="material-icons">&#xE16C;</i>
					    	</a>
					    </div>

				  	</div>
				</div>

				<?php

				mysqli_free_result($result);
			}

			?>

	</div>

	<h1></h1>

</div>

	<div class="fab">
		<div class="btn">
			<a href="<?php pUrl() ?>/admin/create-room-type.php" class="plus">+</a>
		</div>
	</div>
	
	<script type="text/javascript" src="<?php pUrl() ?>/js/jquery.js" ></script>
	<script type="text/javascript" src="<?php pUrl() ?>/js/popper.js" ></script>
	<script type="text/javascript" src="<?php pUrl() ?>/js/bootstrap.js"></script>

</body>
</html>
<?php $db->close(); ?>