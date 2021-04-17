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

	$user = $datastore->entity('user', [
		'id' => "s3783375$i",
		'user_name' => "Manav Gadhoke$i",
		'password' => $password
	]);

	$datastore->upsert($user);
	echo 'Saved ' . $user->key() . ': ' . $user['id'] . PHP_EOL;
}