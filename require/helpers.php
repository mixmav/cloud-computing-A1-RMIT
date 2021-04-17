<?php

	function sanitize_input($input){
		return mysqli_real_escape_string(stripslashes($input));
	}

	function user_is_logged_in(){
		session_start();
		if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
			return true;
		} else {
			return false;
		}
	}