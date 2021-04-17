<?php
	require_once("require/head.php");
?>

<h1>Login page</h1>

<form action="/login" method="POST" class="mt-20">
	<input type="text" placeholder="Your ID" class="text-input blue full-width" name="id" required autofocus>
	<input type="password" placeholder="Your password" class="text-input blue full-width mt-10" name="password" required>
	<button class="btn full-width mt-30 blue jumbo" type="submit"><i class="fa fa-paper-plane"></i>Login</button>
</form>

<a href="/registerpage" class="mt-30 link">Or register :)</a>

<?php
	require_once("require/foot.php");
?>