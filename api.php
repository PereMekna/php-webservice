<?php 
$request = $_SERVER['REQUEST_URI'];
$array = explode("/", $request);

echo json_encode($array);


?>