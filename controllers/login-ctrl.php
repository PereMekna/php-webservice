<?php
   require_once("../services/token-generator.php");
   session_start();
   $m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
   $db = $m->admin;
   $collection = $db->users;
   $tokenGenerator = new TokenGenerator();

   if (isset($_POST["username"]) && isset($_POST["password"])) {
      $logged = $collection->findOne(
         array(
         "username" => $_POST["username"], 
         "password" => $_POST["password"]
         ));
      echo json_encode($logged);
      if (isset($logged)) {
         if ($logged["tokenEnd"] < time()) {
            $token = $tokenGenerator->generate();
            $logged["token"] = $token;
            $newdata = array('$set' => array("token" => $token, "tokenEnd" => time() + (7 * 24 * 60 * 60)));
            $collection->updateOne(
               array(
               "username" => $_POST["username"], 
               "password" => $_POST["username"]
               ), $newdata);
         }
         $_SESSION["username"] = $_POST["username"];
         $_SESSION["token"] = $logged["token"];
      }
      
   }

   header('Location: ../index.php');  

?>