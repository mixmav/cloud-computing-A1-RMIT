<?php
	require_once("require/head.php");
	require_once("require/helpers.php");

	if (!user_is_logged_in()) {
		header("Location: /");
		die();
	}
?>

<h1>Forum page</h1>



<a href="/logout" class="mt-30 link">Logout</a>

<?php
	require_once("require/foot.php");
?>