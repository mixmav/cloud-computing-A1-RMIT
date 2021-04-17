<?php
# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';
require_once('require/helpers.php');

# Imports the Google Cloud client library
use Google\Cloud\Datastore\DatastoreClient;

# Your Google Cloud Platform project ID
$projectId = 'crack-braid-310816';

# Instantiates a client
$datastore = new DatastoreClient([
    'projectId' => $projectId
]);

$query = $datastore->gqlQuery('SELECT * FROM user WHERE id = @idVal and password = @passVal', [
    'bindings' => [
        'idVal' => sanitize_input($_REQUEST['id']),
        'passVal' => sanitize_input($_REQUEST['password']),
    ]
]);

$res = $datastore->runQuery($query);

if(!$res->current() || empty($res->current()) || $res->current() == ""){
	echo "Invalid username/password.";
} else {
	session_start();
	$_SESSION['userLoggedIn'] = true;
	$_SESSION['id'] = $res->current()['user_name'];

	header('Location: /forum');
	die();
}