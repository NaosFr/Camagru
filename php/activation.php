<?php

include('connexion.php');

$login = $_GET['log'];
$cle = $_GET['cle'];
$cle = intval($cle);

$stmt = $bdd->prepare("SELECT cle, confirm FROM users WHERE login like :login ");
if($stmt->execute(array(':login' => $login)) && $row = $stmt->fetch())
  {
    $clebdd = $row['cle'];
    $confirm = $row['confirm'];
  }

if($confirm == '1')
  {
    echo "<style>.alert { display: block!important; background-color: #568456!important;} </style>";
    $txt = "Votre compte est déjà actif !";
  }
else
  {

     if($cle == $clebdd)
       {
          echo "<style>.alert { display: block!important; background-color: #568456!important;} </style>";
          $txt = "Votre compte a bien été activé !";
 
          $stmt = $bdd->prepare("UPDATE users SET confirm = 1 WHERE login like :login ");
          $stmt->bindParam(':login', $login);
          $stmt->execute();
       }
     else
       {
          echo "<style>.alert { display: block!important; } </style>";echo "<style>.alert { display: block!important; } </style>";
          $txt = "Erreur ! Votre compte ne peut être activé...";
       }
  }
 
 ?>


<!DOCTYPE html>
<html id='HTML' xmlns:og="http://ogp.me/ns#" lang="fr">
<head>
  <meta charset="utf-8">
  <title>Camagru - Confirmation</title>
  <meta name="Content-Language" content="fr">
  <meta name="Description" content="">
  <meta name="keyword" content="">
  <meta name="Subject" content="">
  <meta name="Author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="Copyright" content="© 2018 42. All rights reserved.">
  <link rel="icon" type="image/png" href="asset/icon/favicon.png" />

  <!-- ******* CSS ***************** -->
  <link rel="stylesheet" type="text/css" href="../css/main.css">
  <style type="text/css">
    .background_menu{
      width: 100%;
      height: 100%;
      position: relative;
      text-align: center;
      justify-content: center;
      -webkit-justify-content: center;
      align-items: center;
      -webkit-align-items: center;
      display: -webkit-flex;
      cursor: pointer;
    }

    .title_square{
      position: relative;
      font-size: 3.5vw;
      color: white; 
      padding: 20px;
      border: 1px solid white;
      background-color: #262626bf;
      -webkit-transition: .5s ease-out;
      -moz-transition: .5s ease-out;
      -o-transition: .5s ease-out;
      -ms-transition: .5s ease-out;
      transition: .5s ease-out;
    }
    
    .title_square a{
        color: white;
    }

    .title_square:hover{
      background-color: #f9f2f254;
    }
  </style>
</head>

<body>
<!-- ******* HEADER ***************** -->
  <header class="float_menu">
      <a href="index.php"><img src="../assets/icon/logo.png" alt="logo" class="logo"/></a>
  </header>

<!-- ******* ERROR ***************** -->
<div id="alert" class="alert">
  <span class="closebtn">&times;</span> 
  <p><?php echo $txt; ?></p>
</div>

<!-- ******* BACKGROUND CONFIRMATION ***************** -->
  <section class="background_menu">
    <h1 class="title_square"><a href="../account_login.php">LOGIN CAMAGRU</a></h1>
  </section>

<script type="text/javascript" src="../js/main.js"></script>
</body>
</html>