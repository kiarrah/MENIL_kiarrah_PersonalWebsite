<?php
	
	session_start();
	require_once('util/util.php');
 	require_once('util/connection.php');
 	
	if (isset($_SESSION['account']) && $_SESSION['account']['level'] == 'ADMIN') {
		redirect('/admin');
	} else if (isset($_SESSION['account']) && $_SESSION['account']['level'] == 'USER') {
		redirect('/home.php');
	}

	if (isset($_POST['login'])) {

		try {

			$username = $_POST['username'];
			$password = $_POST['password'];

			if ($username == '') {
				throw new Exception('Empty username.');
			} else if ($password == '') {
				throw new Exception('Empty password.');
			}

			$db = DB::getInstance()->getConnection();

			if ($result = $db->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'")) {

				$account = $result->fetch_assoc();
				$_SESSION['account'] = $account;

				if ($account['level'] == 'ADMIN') {
					redirect('/admin');
				} else if ($account['level'] == 'USER') {
					redirect('/home.php');
				}

			}

		} catch (Exception $e) {

			echo $e->getMessage() . '</br>';
			
		}

	}
	
		

?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/login.css" type="text/css" />
<head>
	<title>Login</title>
</head>
<body style="Background-color: gray;">

	<form class="modal-content" method="POST" action="">
		<div class="container">
		<center><b>KEEP CALM AND LOVE YOUR JOB</b></center>
		<br>
        <b>Username</b>
		<input type="text" name="username" required>
		<b>Password</b>
		<input type="password" name="password" required>
		<input type="submit" class="button1" name="login" value="Login"><span></span>
		</div>
	</form>


</body>
</html>