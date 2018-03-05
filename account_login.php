<?php
include('php/connexion.php');
session_start();

	$secret = "6Ld10kMUAAAAAIuGcqRmKg1UKGBhNv1_HHoUXipV";
	$response = $_POST['g-recaptcha-response'];
	$remoteip = $_SERVER['REMOTE_ADDR'];

	$api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" 
	    . $secret
	    . "&response=" . $response
	    . "&remoteip=" . $remoteip ;
	
	$decode = json_decode(file_get_contents($api_url), true);
	
	if (isset($_POST['login']) && isset($_POST['password']) && $_POST['login'] != "" && $_POST['password'] != "")
		{
		if ($decode['success'] == true) {
			$login = htmlspecialchars($_POST['login']);
			$passwd = htmlspecialchars($_POST['password']);
			$passwd = hash("whirlpool", htmlspecialchars($passwd));
			
			$req = $bdd->prepare('SELECT id_user, confirm FROM users WHERE login = ? AND passwd = ?');
			$req->execute(array($login, $passwd));
			if($req->rowCount() == 1)
			{
				$data = $req->fetch();
				if ($data['confirm'] == 0)
				{
					echo "<style>.alert { display: block!important; } </style>";
					$txt = "ERROR : Email not confirmed !";
				}
				else
				{
					$_SESSION['id'] = $data['id_user'];
					$_SESSION['login'] = $login;
					header('Location: index.php');
					exit;
				}
			}
			else
			{
				echo "<style>.alert { display: block!important; } </style>";
				$txt = "ERROR : login or password wrong!";
			}
		}
		else {
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : captcha !";
		}
	}
	

?>

<!DOCTYPE html>
<html id='HTML' xmlns:og="http://ogp.me/ns#" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Login</title>
	<meta name="Content-Language" content="fr">
	<meta name="Description" content="">
	<meta name="keyword" content="">
	<meta name="Subject" content="">
	<meta name="Author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="Copyright" content="© 2018 42. All rights reserved.">
	<link rel="icon" type="image/png" href="asset/icon/favicon.png" />

	<script src='https://www.google.com/recaptcha/api.js'></script>
		
	<!-- ******* CSS ***************** -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/account_login.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
</head>

<body>
<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="index.php"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			<div class="float_menu_rigth">
				<a href="index.php"><h2>HOME</h2></a>
			</div>
	</header>

<!-- ******* ERROR ***************** -->
	<div id="alert" class="alert">
  		<span class="closebtn">&times;</span> 
  		<p><?php echo $txt; ?></p>
	</div>

<!-- ******* FORMULAIRE ***************** -->
	<section id="page_account-login">
		<!-- Form -->
          <form method="post" action="account_login.php" accept-charset="utf-8">

			<label for="login"><p>PSEUDO</p></label>
			<br/>
			<input type="login" name="login" maxlength="40" required value="<?php echo $login; ?>" />

			<label for="password"><p>PASSWORD</p></label>
			<br/>
			<input type="password" name="password" maxlength="20" required />
			
			<div id="capatcha">
				<div class="g-recaptcha" data-sitekey="6Ld10kMUAAAAAIe51_5J7Swv7sG6j_8k5bxl5OZT"></div>
			</div>

        	<p class="register"><a href="account_register.php">REGISTER</a></p>
        	<p class="forgot"><a href="passwd_forgot.php">FORGOT PASSWORD</a></p>
        	<!-- SIGN IN -->
			<input type="submit" name="go_login_account" value="SIGN IN" class="login_submit"/>
          </form>
          <!-- /end Form -->
	</section>

<script type="text/javascript" src="js/main.js"></script>
</body>
</html>