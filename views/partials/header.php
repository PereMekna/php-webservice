<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
     
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">WS</a>
      </div>

     
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="register.php">S'inscrire</a></li>
          <li><a href="#">API</a></li>
        </ul>
        <?php 
          if (!isset($_SESSION["username"])) {
        ?>
        <form id="signin" class="navbar-form navbar-right" role="form">
                          <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                              <input id="email" type="email" class="form-control" name="email" value="" placeholder="Email Address">                                        
                          </div>

                          <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                              <input id="password" type="password" class="form-control" name="password" value="" placeholder="Password">                                        
                          </div>

                          <button type="submit" class="btn btn-primary">Login</button>
                     </form>
                     <?php } ?>
       <?php 
         if (isset($_SESSION["username"])) {
       ?>
       <ul class="nav navbar-nav"><li><p>Connecté</p></li></ul>
       <?php } ?>

      </div>
    </div>
  </nav>