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
$subject = $_REQUEST['subject'];
$message = $_REQUEST['message'];


$picture = $_FILES['picture'];

$target_file = basename($picture["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if(!getimagesize($picture["tmp_name"])) {
	header('Location: /forumpage?showMessage=' . urlencode("Error: file is not an image"));
	die();
}

// Check file size
if ($picture["size"] > 500000) {
	header('Location: /forumpage?showMessage=' . urlencode("Error: image size too large"));
	die();
}

// Only allow jpg, jpeg, png, and gif file types
if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
	header('Location: /forumpage?showMessage=' . urlencode("Error: Usupported image format"));
	die();
}

$unique_id = md5($username . uniqid(rand(), true)) . "." . $imageFileType;

$key = $datastore->key('ForumMessage', $unique_id);
$date = new DateTime("now", new DateTimeZone('Australia/Melbourne'));

$forumMessage = $datastore->entity($key, [
	'uid' => $unique_id,
	'user_name' => $username,
	'subject' => $subject,
	'message' => $message,
	'updated_at' => $date->format("d-m-Y h:i:sa")
]);

$datastore->upsert($forumMessage);


$storage = new StorageClient();
$file = fopen($picture['tmp_name'], 'r');
$bucket = $storage->bucket("rmit-assignment-1");

$object = $bucket->upload($file, [
	'name' => "forum_images/$unique_id"
]);


header('Location: /forumpage?showMessage=' . urlencode("Post successfully created"));
die();