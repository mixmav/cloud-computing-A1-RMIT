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
	$message_uid = $_REQUEST['uid'];


	$projectId = 'crack-braid-310816';

	$datastore = new DatastoreClient([
		'projectId' => $projectId
	]);

	$query = $datastore->gqlQuery('SELECT * FROM ForumMessage WHERE uid = @uidVal', [
		'bindings' => [
			'uidVal' => $message_uid,
		]
	]);

	$res = $datastore->runQuery($query);

	if(!$res->current() || empty($res->current()) || $res->current() == ""){
		$current_message = null;
		header("Location: /user?showMessage=" . urlencode("Coudln't find the message in the database."));
		die();
	} else {
		if($res->current()['user_name'] != $user_name){
			header("Location: /user?showMessage=" . urlencode("You don't have permission to edit this post."));
			die();
		} else {
			$current_message = $res->current();
		}
	}

	require_once("require/head.php");
?>

<h1>Edit message page</h1>
<a href="/user" class="mt-30 link">User page</a>

<form action="/editforummessagepost" method="POST" class="mt-20" enctype="multipart/form-data">
	<input type="hidden" name="uid" value="<?php echo $current_message['uid']; ?>">
	<input type="text" placeholder="Subject" class="text-input full-width" name="subject" required value="<?php echo $current_message['subject']; ?>" autofocus>
	<textarea placeholder="Message text" class="mt-20" name="message" style="padding: 1em; width: 100%" required><?php echo $current_message['message']; ?></textarea>

	<label for="pictureInput" class="mt-30" style="display: inline-block">
		<input id="pictureInput" type="file" name="picture">
	</label>
	<br><br>
	<img style="width: 100%; height: auto;" src="https://storage.googleapis.com/rmit-assignment-1/forum_images/<?php echo $current_message['uid']; ?>" alt="Message image">

	<button class="btn full-width mt-30 blue jumbo"><i class="fa fa-sync-alt"></i>Update message</button>
</form>

<?php
	require_once("require/foot.php");
?>