<?php
	session_start();

	unset($_SESSION['userLoggedIn']);
	unset($_SESSION['id']);

	header('Location: /');
	die();