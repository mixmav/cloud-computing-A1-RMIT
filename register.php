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


$id = escape_string($_REQUEST['id']);
$username = escape_string($_REQUEST['username']);
$password = $_REQUEST['password'];

$query = $datastore->gqlQuery('SELECT * FROM user WHERE id = @idVal', [
	'bindings' => [
		'idVal' => $id,
	]
]);

$res = $datastore->runQuery($query);

if($res->current() || !empty($res->current()) || $res->current() != ""){
	header('Location: /registerpage?showMessage=' . urlencode("Error: ID already exists"));
	die();
}

$query = $datastore->gqlQuery('SELECT * FROM user WHERE user_name = @userNameVal', [
	'bindings' => [
		'userNameVal' => $username,
	]
]);

$res = $datastore->runQuery($query);

if($res->current() || !empty($res->current()) || $res->current() != ""){
	header('Location: /registerpage?showMessage=' . urlencode("Error: Username already exists"));
	die();
}


$picture = $_FILES['picture'];

$target_file = basename($picture["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if(!getimagesize($picture["tmp_name"])) {
	header('Location: /registerpage?showMessage=' . urlencode("Error: file is not an image"));
	die();
}

// Check file size
if ($picture["size"] > 500000) {
	header('Location: /registerpage?showMessage=' . urlencode("Error: image size too large"));
	die();
}

// Only allow jpg files
if($imageFileType != "jpg") {
	header('Location: /registerpage?showMessage=' . urlencode("Error: Only .jpg images are supported"));
	die();
}

$storage = new StorageClient();
$file = fopen($picture['tmp_name'], 'r');
$bucket = $storage->bucket("rmit-assignment-1");

$object = $bucket->upload($file, [
	'name' => "user_images/$id.jpg"
]);



//User doesn't exist -- create one
$key = $datastore->key('user', $id);
$user = $datastore->entity($key, [
	'id' => $id,
	'user_name' => $username,
	'password' => $password
]);

$datastore->insert($user);

header('Location: /?showMessage=' . urlencode("User successfully created"));
die();