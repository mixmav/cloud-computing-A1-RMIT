<?php

require("require/helpers.php");

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$projectId = 'crack-braid-310816';

$datastore = new DatastoreClient([
    'projectId' => $projectId
]);

$query = $datastore->gqlQuery('SELECT * FROM user WHERE id = @idVal and password = @passVal', [
    'bindings' => [
        'idVal' => escape_string($_REQUEST['id']),
        'passVal' => escape_string($_REQUEST['password']),
    ]
]);

$res = $datastore->runQuery($query);

if(!$res->current() || empty($res->current()) || $res->current() == ""){
	header('Location: /?showMessage=' . urlencode("Error: invalid username/password"));
} else {
	$_SESSION['userLoggedIn'] = true;
	$_SESSION['id'] = $res->current()['id'];
	$_SESSION['user_name'] = $res->current()['user_name'];

	header('Location: /forumpage');
}

die();