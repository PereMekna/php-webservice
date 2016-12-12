<?php
   session_start();
   $m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
   $db = $m->admin;
   $collection = $db->users;

   if ($_POST["password"] == $_POST["password_conf"] && $_POST["email"] == $_POST["email_conf"]) {
      $user = array( 
         "username" => $_POST["username"], 
         "password" => $_POST["password"], 
         "email" => $_POST["email"]
      );

      $_SESSION["username"] = $_POST["username"];
      
      $collection->insert($user);
   }

   header('Location: ../index.php'); 

?>