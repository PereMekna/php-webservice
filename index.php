<?php include('views/partials/header.php');
include('controllers/index-ctrl.php'); ?>
<div class="container">

  <h1>Hello, world!</h1>


  <?php if (isset($_SESSION["username"])) { ?>
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
      <div class="list-group">
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
        echo "<a target='_blank' href='./api/".$_SESSION['token'].'/'.$document['name']."' class='list-group-item'>".
        $document["name"] ." <span class='badge'>".
        $numberItem."</span></a>";
      } ?>
      </div>
    </div>
    <div class="panel-footer"><?php echo $numberItemUser; ?> objets dans <?php echo $numberColls; ?> collections</div>
    </div>
  </div>
  <?php } ?>
  <div class="col-md-12">
  <h3 class="dark-grey">Comment ça marche ?</h3>
  <h4 class="grey">Authentification</h4>
  <p>Pour se connecter, on peut soit se connecter via l'interface web, après avoir <a href="register.php">créé un compte</a>, soit utiliser le point d'accès <code>POST urlDuWebService/api/</code>, en envoyant les informations de connections sous la forme d'un objet JSON <code>{"username": "root", "password": "root"}</code>.</p>
  <p>Le service répondra avec un objet JSON contenant le token de connexion de 64 caractères hexadécimaux. Il faudra l'ajouter à chaque requête pour permettre au serveur de connaître l'utilisateur associé. Le corps de la requête aura cette forme <code>POST urlDuWebService/api/$TOKEN/</code>.</p>
  <h4 class="grey">Les collections</h4>
  <p>Avant de pouvoir utiliser l'API, on doit créer une collection via le formulaire ci-dessus. Une collection a uniquement besoin d'un nom. Elle est composée d'objets JSON divers, identifiables avec leurs ObjectId unique.</p>
  <p>Pour consulter l'intégralité des objets contenus dans une collection, il faut utiliser la syntaxe <code>GET urlDuWebService/api/$TOKEN/$COLLECTION</code>.</p>
  </div>
  
</div>
<?php include('views/partials/footer.php'); ?>