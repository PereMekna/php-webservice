<?php 

  
  $m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
  $db = $m->admin;
  $collection = $db->collections; 
  $colls = $collection->find(
     array(
     "username" => $_SESSION["username"]
     ));

  $numberColls = 0;
  foreach ($colls as $value) {
    $numberColls+=1;
  };

  $values = $db->values;
  $collectionsUser = $values->find(
    array(
      "username" => $_SESSION["username"]),
    array(
      "username" => 0,
      "collection" => 0
      ));
  $numberItemUser = 0;
  foreach ($collectionsUser as $value) {
    $numberItemUser+=1;
  };
  ?>