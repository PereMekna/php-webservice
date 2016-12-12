<?php 
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
  case 'PUT':
    do_something_with_put($request);  
    break;
  case 'POST':
    doPost($request);  
    break;
  case 'GET':
    doGet($request);  
    break;
  case 'HEAD':
    do_something_with_head($request);  
    break;
  case 'DELETE':
    do_something_with_delete($request);  
    break;
  case 'OPTIONS':
    do_something_with_options($request);    
    break;
  default:
    handle_error($request);  
    break;
}

function doGet($request) {
	$m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
	$db = $m->admin;
	$collection = $db->users;
	if (isset($_GET["token"])) {
		$user = $collection->findOne(
		   array(
		   "token" => $_GET["token"]
		   ),
		   array(
		   	"password" => 0
		   	));
	}
	if (!isset($_GET["collection"]) && isset($user)) {
		echo json_encode($user);
	}

	if (!isset($user)) {
		http_response_code(401);
		echo json_encode(array(
			"error" => "Unauthorized",
			"errorCode" => 401,
			"message" => "Veuillez vous authentifier pour acceder aux services de l'API"));
	}

	if (isset($_GET["collection"]) && !isset($_GET["index"])) {
		$values = $db->values;
		$collectionToShow = $values->find(
			array(
				"username" => $user["username"],
				"collection" => $_GET["collection"]),
			array(
				"username" => 0,
				"collection" => 0
				));
		$output = "[";
		foreach ($collectionToShow as $value) {
			$output.=json_encode($value).",";
		};
		echo trim($output, ",");
		echo "]";
	}
	if (isset($_GET["index"])) {
		$values = $db->values;
		$objectToShow = $values->findOne(
			array("_id" => new MongoId($_GET["index"])),
			array(
				"username" => 0,
				"collection" => 0
				));
		echo json_encode($objectToShow);
	}	
}


function doPost($request) {
	$m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
	$db = $m->admin;
	$collection = $db->users;
	$entityBody = json_decode(file_get_contents('php://input'));
	if (isset($_GET["token"])) {
		$user = $collection->findOne(
		   array(
		   "token" => $_GET["token"]
		   ),
		   array(
		   	"password" => 0
		   	));
	}
	if (isset($_GET["collection"])) {
		$values = $db->values;
		$identifiers = array(
				"username" => $user["username"],
				"collection" => $_GET["collection"]);

		$object = array_merge((array) $entityBody, (array) $identifiers);
		$collectionToShow = $values->insert($object);
		http_response_code(201);
		echo json_encode($object);
	}

	if (!isset($user)) {
		http_response_code(401);
		echo json_encode(array(
			"error" => "Unauthorized",
			"errorCode" => 401,
			"message" => "Veuillez vous authentifier pour acceder aux services de l'API"));
	}

}
?>