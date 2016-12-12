<?php
   session_start();
   $m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
   $db = $m->admin;
   $collection = $db->users;

   $length = 64;
   $token = bin2hex(openssl_random_pseudo_bytes($length));

   if ($_POST["password"] == $_POST["password_conf"] && $_POST["email"] == $_POST["email_conf"]) {
      $user = array( 
         "username" => $_POST["username"], 
         "password" => $_POST["password"], 
         "email" => $_POST["email"],
         "token" => $token,
         "tokenEnd" => time() + (7 * 24 * 60 * 60)
      );

      $_SESSION["username"] = $_POST["username"];
      $_SESSION["token"] = $token;
      
      $collection->insert($user);
   }

   header('Location: ../index.php'); 

?>