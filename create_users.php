<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Datastore\DatastoreClient;

$projectId = 'crack-braid-310816';

$datastore = new DatastoreClient([
    'projectId' => $projectId
]);

for ($i=0; $i < 10; $i++) {
	$password = "";
	for ($j=$i; $j <= $i + 5; $j++) {
		if ($j >= 10) {
			$to_add = 10 - $j;
		} else {
			$to_add = $j;
		}
		$password .= abs($to_add);
	}
	
	$id = "s3783375$i";

	$key = $datastore->key('user', $id);
	$user = $datastore->entity($key, [
		'id' => $id,
		'user_name' => "Manav Gadhoke$i",
		'password' => $password
	]);

	$datastore->insert($user);
	echo 'Saved ' . $user->key() . ': ' . $user['id'] . PHP_EOL;
}