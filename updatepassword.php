<?php

require("require/helpers.php");

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$projectId = 'crack-braid-310816';

$datastore = new DatastoreClient([
    'projectId' => $projectId
]);

$id = escape_string($_REQUEST['id']);
$old_password = $_REQUEST['old_password'];
$new_password = $_REQUEST['new_password'];

$query = $datastore->gqlQuery('SELECT * FROM user WHERE id = @idVal and password = @passVal', [
    'bindings' => [
        'idVal' => $id,
        'passVal' => $old_password,
    ]
]);

$res = $datastore->runQuery($query);

if(!$res->current() || empty($res->current()) || $res->current() == ""){
	header('Location: /user?showMessage=' . urlencode("Error: old password doesn't match."));
} else {
	$transaction = $datastore->transaction();
	$key = $datastore->key('user', $id);
	$user = $transaction->lookup($key);

	$user['password'] = $new_password;
	$transaction->update($user);
	$transaction->commit();
	
	//Log 'em out
	session_start();

	unset($_SESSION['userLoggedIn']);
	unset($_SESSION['id']);
	unset($_SESSION['user_name']);

	header('Location: /?showMessage=' . urlencode("Password changed. Login again."));
	die();
}

die();