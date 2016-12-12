<?php include('views/partials/header.php'); ?>
<div class="container">

  <h1>Hello, world!</h1>

  <?php 

    if (isset($_SESSION["username"])) {
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
  
  <div class="col-md-6">
    <form action="controllers/collection-ctrl.php" method="POST">
      <h3 class="dark-grey">Ajouter une collection</h3>
      
      <div class="form-group col-lg-12">
        <label>Nom</label>
        <input type="text" name="collection_name" class="form-control" id="" value="">
      </div>

      <div class="form-group col-lg-6">
        <button type="submit" class="btn btn-primary">Ajouter</button>
      </div>        
    </form>
    
  </div>
  <div class="col-md-6">
    <div class="panel panel-primary">
    <div class="panel-heading">Mes collections</div>
    <div class="panel-body">
      <ul class="list-group">
        <?php


        foreach ($colls as $document) {
        $collectionToShow = $values->find(
          array(
            "username" => $_SESSION["username"],
            "collection" => $document["name"]),
          array(
            "username" => 0,
            "collection" => 0
            ));
            
            $numberItem = 0;
            foreach ($collectionToShow as $value) {
              $numberItem+=1;
            };
            echo "<li class='list-group-item'>".$document["name"] ." <span class='badge'>".$numberItem."</span></li>";
        }
        ?>
      </ul>
    </div>
    <div class="panel-footer"><?php echo $numberItemUser; ?> objets dans <?php echo $numberColls; ?> collections</div>
    </div>
  </div>
  <?php } ?>
</div>
<?php include('views/partials/footer.php'); ?>