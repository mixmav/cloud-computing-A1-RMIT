<?php
	require __DIR__ . '/vendor/autoload.php';

	use Google\Cloud\Datastore\DatastoreClient;

	session_start();
	require_once("require/helpers.php");

	if (!user_is_logged_in()) {
		header("Location: /?showMessage=" . urlencode("Please login to view the page"));
		die();
	}

	$id = $_SESSION['id'];
	$user_name = $_SESSION['user_name'];



	$projectId = 'crack-braid-310816';

	$datastore = new DatastoreClient([
		'projectId' => $projectId
	]);

	$query = $datastore->gqlQuery('SELECT * FROM ForumMessage WHERE user_name = @usernameVal', [
		'bindings' => [
			'usernameVal' => $user_name,
		]
	]);

	$res = $datastore->runQuery($query);

	if(!$res->current() || empty($res->current()) || $res->current() == ""){
		$latestMessages = null;
	} else {
		$latestMessages = $res;
	}

	require_once("require/head.php");
?>

<h1>User page</h1>
<a href="/forumpage" class="mt-30 link">Forum page</a>
<h2 class="mt-30"><i class="fa fa-unlock-alt"></i>&nbsp;Update your password</h2>

<form action="/update-password" method="POST" class="mt-20">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<input type="password" placeholder="Old password" class="text-input full-width" name="old_password" required autofocus>
	<input type="password" placeholder="New password" class="text-input full-width mt-10" name="new_password" required>
	<button class="btn full-width mt-30 green jumbo" type="submit"><i class="fa fa-paper-plane"></i>Update password</button>
</form>

<h2 class="mt-50">Latest messages by <?php echo $user_name; ?></h2>
	<?php
		if(is_null($latestMessages)){
			echo "<h3 class='mt-30'><i class='fa fa-thermometer-empty'></i>&nbsp;No messages yet. Write one!</h3>";
		} else {
			echo '<ul class="mt-30">';

			while($latestMessages->valid()){
				echo "<li class='mt-80'>";
					echo "<span class='red-bold'>Subject: </span>" . $latestMessages->current()['subject'] . "<br>";
					echo "<span class='red-bold'>Posted on </span>" . $latestMessages->current()['updated_at'] . "<br><br>";
					echo "<span class='red-bold'>Message: </span>" . $latestMessages->current()['message'] . "<br><br>";
					echo '<img style="width: 100%; height: auto;" src="https://storage.googleapis.com/rmit-assignment-1/forum_images/' . $latestMessages->current()['uid'] . '" alt="Message image"><br><br>';
					echo "<a href='/editforummessagepage?uid=" . $latestMessages->current()['uid'] . "' class='btn full-width red'><i class='fa fa-edit'></i>Edit</a><br><br>";

					$latestMessages->next();
				echo "</li>";
			}
			echo "</ul>";
		}
	?>

<?php
	require_once("require/foot.php");
?>