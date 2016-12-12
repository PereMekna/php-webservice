<?php
session_start();
$m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
$db = $m->admin;
$collection = $db->collections;
	if (isset($_POST["collection_name"])) {
		$item = array(
			"username" => $_SESSION["username"],
			"name" => $_POST["collection_name"]
			);
		$collection->insert($item);
	}
header('Location: ../index.php'); 
?>