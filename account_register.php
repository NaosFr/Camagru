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

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_conf']) && isset($_POST['email']) && $_POST['login'] != "" && $_POST['password'] != "" && $_POST['password_conf'] != "" && $_POST['email'] != "")
{	
	$email = htmlspecialchars($_POST['email']);
	$login = htmlspecialchars($_POST['login']);
	$passwd = htmlspecialchars($_POST['password']);
	$passwd_conf = htmlspecialchars($_POST['password_conf']);
	$passwd = hash("whirlpool", htmlspecialchars($passwd));
	$passwd_conf = hash("whirlpool", htmlspecialchars($passwd_conf));

	if ($decode['success'] == true) {
		
		if ($_POST['password'] != $_POST['password_conf'])
		{
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Passwords don't match";
		}
		else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Not a valid email";
		}
		else if (strlen($_POST['password']) < 5){
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Password too short";
		}
		else if (!preg_match("#[0-9]+#", $_POST['password'])){
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Password must include a number";
		}
		else if (!preg_match("#[a-zA-Z]+#", $_POST['password'])){
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Password must include a letter";
		}
		else{
			
			$req = $bdd->prepare('SELECT id_user FROM users WHERE login = ?');
			$req->execute(array($login));

			$req2 = $bdd->prepare('SELECT id_user FROM users WHERE email = ?');
			$req2->execute(array($email));

			if($req->rowCount() > 0)
			{
				echo "<style>.alert { display: block!important; } </style>";
				$txt = "ERROR : Pseudo already use !";
			}
			else if ($req2->rowCount() > 0) {
				echo "<style>.alert { display: block!important; } </style>";
				$txt = "ERROR : Email already use !";
			}
			else
			{
				$req = $bdd->prepare('INSERT INTO users (email, login, passwd, confirm) VALUES (:email, :login, :passwd, 0)');
				$req->execute(array(
					'email' => $email,
					'login' => $login,
					'passwd' => $passwd
					));


				$cle = md5(microtime(TRUE)*100000);
				$stmt = $bdd->prepare("UPDATE users SET cle=:cle WHERE login like :login");
				$stmt->bindParam(':cle', $cle);
				$stmt->bindParam(':login', $login);
				$stmt->execute();

				ini_set( 'display_errors', 1 );
		    	error_reporting( E_ALL );

				$sujet = "Active your account" ;
				$header = "From: adm@camagru.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

				$message = '<html>
						      <head>
						       <title>Welcome to Camagru</title>
						      </head>
						      <body>
						       <img src="http://localhost:8888/assets/icon/logo2.png" style="width: 100px;">
						       <p>To validate your account, please click on the link below or copy / paste in your internet browser.<br>http://localhost:8888/php/activation.php?log='.urlencode($login).'&cle='.urlencode($cle).'<br>------------------------------------------------------------------------------------------<br>This is an automatic email, please do not reply.</p>
						      </body>
						     </html>';

				mail($email, $sujet, $message, $header);
				header('Location: account_login.php');
				exit;
			}
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
	<title>Camagru - Register</title>
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
	<link rel="stylesheet" type="text/css" href="css/account_register.css">
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
	<section id="page_account-register">
		<!-- Form -->
        <form method="post" action="account_register.php" accept-charset="utf-8">
			<label for="email"><p>EMAIL</p></label>
			<br/>
			<input type="email" name="email" maxlength="40" required value="<?php echo $email; ?>" />
			
			<label for="login"><p>PSEUDO</p></label>
			<br/>
			<input type="login" name="login" maxlength="40" required value="<?php echo $login; ?>"/>

			<label for="password"><p>PASSWORD</p></label>
			<br/>
			<input type="password" name="password" maxlength="20" minlength="5" required />
			
			<label for="password_conf"><p>CONFIRMATION PASSWORD</p></label>
			<br/>
			<input type="password" name="password_conf" maxlength="20" minlength="5" required />
			
			<div id="capatcha">
				<div class="g-recaptcha" data-sitekey="6Ld10kMUAAAAAIe51_5J7Swv7sG6j_8k5bxl5OZT"></div>
			</div>

			<p class="register"><a href="account_login.php">LOGIN</a></p>
			<!-- CREATE ACCOUNT -->
			<input type="submit" name="create_account" value="CREATE ACCOUNT" class="register_submit"/>
		</form>
	</section>

<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
