<?php
	// use Google\Cloud\Datastore\DatastoreClient;

	function user_is_logged_in(){
		if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
			return true;
		} else {
			return false;
		}
	}

	function escape_string($value){
		$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

		return str_replace($search, $replace, $value);
	}

	// function get_auth_user($id){
	// 	# Your Google Cloud Platform project ID
	// 	$projectId = 'crack-braid-310816';

	// 	# Instantiates a client
	// 	$datastore = new DatastoreClient([
	// 		'projectId' => $projectId
	// 	]);

	// 	$query = $datastore->gqlQuery('SELECT * FROM user WHERE id = @idVal and password = @passVal', [
	// 		'bindings' => [
	// 			'idVal' => escape_string($id),
	// 		]
	// 	]);

	// 	$res = $datastore->runQuery($query);

	// 	if(!$res->current() || empty($res->current()) || $res->current() == ""){
	// 		return false;
	// 	} else {
	// 		return [
	// 			'id' => $res->current()['user_name'],
	// 			'user_name' => $res->current()['user_name'],

	// 		];
	// 	}
	// }