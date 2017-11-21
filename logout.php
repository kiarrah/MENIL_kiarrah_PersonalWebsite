<?php
	require_once('util/util.php');
	session_start();
	session_destroy();
	redirect("/"); 
?>