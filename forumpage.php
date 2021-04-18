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

	$query = $datastore->gqlQuery('SELECT * FROM ForumMessage ORDER BY updated_at DESC LIMIT @limitVal', [
		'bindings' => [
			'limitVal' => 10,
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

<h1>Forum page</h1>
<h2 class="mt-30">Welcome, <a class="link" href="/user"><?php echo $user_name; ?></a></h2>
<a href="/logout" class="mt-20 link"><i class="fa fa-sign-out-alt"></i>Logout</a>
<img src="https://storage.googleapis.com/rmit-assignment-1/user_images/<?php echo $id; ?>.jpg" alt="User image" width="120" height="120" style="border-radius: 100%; display: block;" class="mt-30">

<h2 class="mt-50">Post a message</h2>
<form action="/forumpost" method="POST" class="mt-20" enctype="multipart/form-data">
	<input type="text" placeholder="Subject" class="text-input full-width" name="subject" required autofocus>
	<textarea placeholder="Message text" class="mt-20" name="message" style="padding: 1em; width: 100%" required></textarea>
	<label for="pictureInput" class="mt-30" style="display: inline-block">
		<input id="pictureInput" type="file" name="picture" required>
	</label>

	<button class="btn full-width mt-30 green jumbo"><i class="fa fa-plus-square"></i>Add post</button>
</form>

<h2 class="mt-50">Latest messages</h2>
	<?php
		if(is_null($latestMessages)){
			echo "<h3 class='mt-30'><i class='fa fa-thermometer-empty'></i>&nbsp;No messages yet. Write one!</h3>";
		} else {
			echo '<ul class="mt-30">';
			
				while($latestMessages->valid()){
					echo "<li class='mt-80'>";
						echo "<span class='red-bold'>Subject: </span>" . $latestMessages->current()['subject'] . "<br>";
						echo "<span class='red-bold'>Posted by </span>" . $latestMessages->current()['user_name'] . "<span class='red-bold'> at </span>" . $latestMessages->current()['updated_at'] . "<br><br>";
						echo "<span class='red-bold'>Message: </span>" . $latestMessages->current()['message'] . "<br><br>";
						echo '<img style="width: 100%; height: auto;" src="https://storage.googleapis.com/rmit-assignment-1/forum_images/' . $latestMessages->current()['uid'] . '" alt="Message image"';

						$latestMessages->next();
					echo "</li>";
				}

			echo "</ul>";
		}
	?>

<?php
	require_once("require/foot.php");
?>