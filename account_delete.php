<?php
include('php/connexion.php');

if (isset($_POST['password']) && $_POST['password'] != "" && isset($_POST['email']) && $_POST['email'] != "")
{
	$email = htmlspecialchars($_POST['email']);
	$passwd = htmlspecialchars($_POST['password']);
	$passwd = hash("whirlpool", htmlspecialchars($passwd));

	$req = $bdd->prepare('SELECT * FROM users WHERE email = ? AND passwd = ?');
	$req->execute(array($email, $passwd));
	if($req->rowCount() == 1)
	{
		$data = $req->fetch();
		$req2 = $bdd->prepare('DELETE FROM users WHERE id_user=:id');
		$req2->bindParam(':id', $data['id_user'], PDO::PARAM_INT);
		$req2->execute();
		header('Location: php/logout.php');
	}
	else{
		echo "<style>.alert { display: block!important; } </style>";
		$txt = "ERROR : email or password wrong!";
	}
}

?>

<!DOCTYPE html>
<html id='HTML' xmlns:og="http://ogp.me/ns#" lang="fr">
<head>
	<meta charset="utf-8">
	<title>camagru - Delete</title>
	<meta name="Content-Language" content="fr">
	<meta name="Description" content="">
	<meta name="keyword" content="">
	<meta name="Subject" content="">
	<meta name="Author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="Copyright" content="© 2018 42. All rights reserved.">
	<link rel="icon" type="image/png" href="asset/icon/favicon.png" />
		
	<!-- ******* CSS ***************** -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/account_delete.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	
</head>

<body>
<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="index.php"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			<div class="float_menu_rigth">
				<a href="index.php"><h2>HOME</h2></a>
				<a href="studio.php"><h2>STUDIO</h2></a>
				<a href="account_setting.php"><h2>SETTING</h2></a>
				<a href="php/logout.php"><h2>LOGOUT </h2></a>
			</div>
	</header>

<!-- ******* ERROR ***************** -->
<div id="alert" class="alert">
  <span class="closebtn">&times;</span> 
  <p><?php echo $txt; ?></p>
</div>

<!-- ******* FORMULAIRE ***************** -->
	<section class="background_menu" id="page_account-delete">
		<!-- Form -->
          <form method="post" action="account_delete.php" accept-charset="utf-8">

			<label for="email"><p>EMAIL</p></label>
			<br/>
			<input type="email" name="email" maxlength="40" required />
			
			<label for="password"><p>PASSWORD</p></label>
			<br/>
			<input type="password" name="password" maxlength="20" required />

        	<!-- SIGN IN -->
			<input type="submit" name="go_delete_account" value="DELETE" class="delete_submit"/>
          </form>
          <!-- /end Form -->
	</section>

<script type="text/javascript" src="js/main.js"></script>
</body>
</html>