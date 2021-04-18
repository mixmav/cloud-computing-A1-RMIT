<?php

session_start();
require("require/helpers.php");

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Datastore\DatastoreClient;

$projectId = 'crack-braid-310816';

$datastore = new DatastoreClient([
	'projectId' => $projectId
]);

$storage = new StorageClient([
    'projectId' => $projectId,
    'keyFilePath' => 'require/crack-braid-310816-efe1d5acf5b1.json'
]);

$username = $_SESSION['user_name'];
$message_uid = $_REQUEST['uid'];
$subject = $_REQUEST['subject'];
$message = $_REQUEST['message'];

$changeUid = false;
$unique_id = "";

if(!$_FILES['picture']['error']){
	$picture = $_FILES['picture'];

	$target_file = basename($picture["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	if(!getimagesize($picture["tmp_name"])) {
		header('Location: /editforummessagepage?uid='. $message_uid . '&showMessage=' . urlencode("Error: file is not an image"));
		die();
	}

	// Check file size
	if ($picture["size"] > 500000) {
		header('Location: /editforummessagepage?uid='. $message_uid . '&showMessage=' . urlencode("Error: image size too large"));
		die();
	}

	// Only allow jpg, jpeg, png, and gif file types
	if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
		header('Location: /editforummessagepage?uid='. $message_uid . '&showMessage=' . urlencode("Error: Usupported image format"));
		die();
	}

	$unique_id = md5($username . uniqid(rand(), true)) . "." . $imageFileType;

	$storage = new StorageClient();
	$bucket = $storage->bucket("rmit-assignment-1");

	//Delete the old object
	$object = $bucket->object("forum_images/" . $message_uid);
	$object->delete();

	$file = fopen($picture['tmp_name'], 'r');
	$object = $bucket->upload($file, [
		'name' => "forum_images/$unique_id"
	]);

	$changeUid = true;
}


$transaction = $datastore->transaction();
$key = $datastore->key('ForumMessage', $message_uid);
$forumMessage = $transaction->lookup($key);


if($changeUid){
	$forumMessage['uid'] = $unique_id;
}

$date = new DateTime("now", new DateTimeZone('Australia/Melbourne'));

$forumMessage['subject'] = $subject;
$forumMessage['message'] = $message;
$forumMessage['updated_at'] = $date->format("d-m-Y h:i:sa");

$transaction->update($forumMessage);
$transaction->commit();


header('Location: /forumpage?showMessage=' . urlencode("Message successfully updated"));
die();