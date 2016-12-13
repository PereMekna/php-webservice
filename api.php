<?php 
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header('Content-Type: application/json');

switch ($method) {
  case 'PUT':
    doPut($request);  
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
    doDelete($request);  
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
		$nbItems = $values->count(array(
			"username" => $user["username"],
			"collection" => $_GET["collection"]));
		if ($nbItems > 0) {
			$collectionToShow = $values->find(
				array(
					"username" => $user["username"],
					"collection" => $_GET["collection"]),
				array(
					"username" => 0,
					"collection" => 0
					));
			http_response_code(200);
			$output = "[";
			foreach ($collectionToShow as $value) {
				$output.=json_encode($value).",";
			};
			echo trim($output, ",");
			echo "]";
		} else {
			http_response_code(204);
		}

	}
	if (isset($_GET["index"])) {
		$values = $db->values;
		$objectToShow = $values->findOne(
			array("_id" => new MongoId($_GET["index"])),
			array(
				"username" => 0,
				"collection" => 0
				));
		if ($objectToShow !== null) {
			http_response_code(200);
			echo json_encode($objectToShow);
		} else {
			http_response_code(204);
		}
	}	
}


function doPost($request) {
	require_once("./services/token-generator.php");
	$tokenGenerator = new TokenGenerator();
	$m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
	$db = $m->admin;
	$collection = $db->users;
	$entityBody = json_decode(file_get_contents('php://input'), 1);
	if (isset($_GET["token"])) {
		$user = $collection->findOne(
		   array(
		   "token" => $_GET["token"]
		   ),
		   array(
		   	"password" => 0
		   	));
	}
	if (isset($entityBody) && isset($entityBody["username"]) && isset($entityBody["password"])) {
		$users = $db->users;

		$user = $users->findOne(array(
			'username' => $entityBody["username"],
			'password' => $entityBody["password"] ),
		array(
			'password' => 0));
		http_response_code(200);
		echo json_encode($user);

		exit();
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

function doDelete($request) {
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
	if (!isset($_GET["token"])) {
		http_response_code(401);
		echo json_encode(array(
			"error" => "Unauthorized",
			"errorCode" => 401,
			"message" => "Veuillez vous authentifier pour acceder aux services de l'API"));
	}
	if (isset($_GET["collection"]) && isset($_GET["index"])) {
		$values = $db->values;
		$values->remove(
			array("_id" => new MongoId($_GET["index"])));
		http_response_code(204);
		echo json_encode(array(
			"delete" => "L'objet avec l'_id ".$_GET["index"]." a été supprimé."));
	}
}

function doPut($request) {
	$m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
	$db = $m->admin;
	$collection = $db->users;
	if (isset($_GET["token"]) && isset($_GET["index"])) {
		$user = $collection->findOne(
		   array(
		   "token" => $_GET["token"]
		   ),
		   array(
		   	"password" => 0
		   	));
		$collection = $db->values;
		$entityBody = json_decode(file_get_contents('php://input'), 1);
		$newdata = array('$set' => $entityBody);
		$newObject = $collection->update(
		   array(
		   "_id" => new MongoId($_GET["index"])
		   ), $newdata);
		http_response_code(200);
		echo json_encode($collection->findOne(
			array(
				 "_id" => new MongoId($_GET["index"])),
			array(
				"username" => 0,
				"collection" => 0
				)
			));
	}
	
	

}
?>