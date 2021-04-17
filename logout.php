<?php
	session_start();

	unset($_SESSION['userLoggedIn']);
	unset($_SESSION['id']);
	unset($_SESSION['user_name']);

	header('Location: /');
	die();