<?php
	session_start();
	require_once("require/helpers.php");

	if (user_is_logged_in()) {
		header("Location: /forumpage");
		die();
	}

	require_once("require/head.php");
?>

<h1>Login page</h1>

<form action="/login" method="POST" class="mt-20">
	<input type="text" placeholder="Your ID" class="text-input full-width" name="id" required autofocus>
	<input type="password" placeholder="Your password" class="text-input full-width mt-10" name="password" required>
	<button class="btn full-width mt-30 green jumbo" type="submit"><i class="fa fa-paper-plane"></i>Login</button>
</form>

<a href="/registerpage" class="mt-30 link">Or register :)</a>

<?php
	require_once("require/foot.php");
?>