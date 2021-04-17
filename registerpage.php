<?php
	session_start();
	require_once("require/helpers.php");

	if (user_is_logged_in()) {
		header("Location: /forum");
		die();
	}

	require_once("require/head.php");
?>

<h1>Register page</h1>

<form action="/register" method="POST" class="mt-20">
	<input type="text" placeholder="Your ID" class="text-input blue full-width" name="id" required autofocus>
	<input type="text" placeholder="New username" class="text-input blue full-width mt-10" name="username" required>
	<input type="password" placeholder="New password" class="text-input blue full-width mt-10" name="password" required>
	<label for="pictureInput" class="mt-30" style="display: inline-block">
		<input id="pictureInput" type="file" name="picture" required>
	</label>
	<button class="btn full-width mt-30 green jumbo"><i class="fa fa-plus-square"></i>Register</button>
</form>

<a href="/" class="mt-30 link">Login</a>

<?php
	require_once("require/foot.php");
?>