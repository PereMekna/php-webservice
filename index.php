<?php include('views/partials/header.php'); ?>
<div class="container">

  <h1>Hello, world!</h1>

  <?php 

    if (isset($_SESSION["username"])) {
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
    <div class="well">
      <h3 class="dark-grey">Mes collections</h3>
      <ul>
        <?php
        $m = new MongoClient("mongodb://louis:lambda@reggaeshark.eu");
        $db = $m->admin;
        $collection = $db->collections; 
        $colls = $collection->find(
           array(
           "username" => $_SESSION["username"]
           ));
        foreach ($colls as $document) {
            echo "<li>".$document["name"] . "</li><br />";
        }
        ?>
      </ul>
    </div>
  </div>
  <?php } ?>
</div>
<?php include('views/partials/footer.php'); ?>