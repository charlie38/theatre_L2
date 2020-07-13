<?php
	session_start();
	if(isset($_SESSION['login'])
		&& isset($_SESSION['motdepasse'])
		&& !empty($_SESSION['login'])
		&& !empty($_SESSION['motdepasse'])
	) {
		header('Status: 304');
		header('location: menu.php');
	} else {
		header('Status: 304');
		header('location: connexion.php');
	}
?>