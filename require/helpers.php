<?php
	function user_is_logged_in(){
		if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
			return true;
		} else {
			return false;
		}
	}