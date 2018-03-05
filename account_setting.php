<?php
include('php/connexion.php');


if (isset($_POST['go_modify_account'])) {

if (isset($_POST['login']) 
	&& $_POST['login'] != "" 
	&& isset($_POST['email']) 
	&& $_POST['email'] != "")
{
		$email = htmlspecialchars($_POST['email']);
		$login = htmlspecialchars($_POST['login']);

		$req_login = $bdd->prepare('SELECT id_user FROM users WHERE login = ? AND id_user != '.$_SESSION['id'].'');
		$req_login->execute(array($login));

		$req_email = $bdd->prepare('SELECT id_user FROM users WHERE email = ? AND id_user != '.$_SESSION['id'].'');
		$req_email->execute(array($email));

		if($req_login->rowCount() > 0)
		{
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Pseudo already use !";
		}
		else if ($req_email->rowCount() > 0) {
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Email already use !";
		}
		else{
			$req = $bdd->prepare('SELECT * FROM users WHERE login = ? AND id_user = ?');
			$req->execute(array($_SESSION['login'] , $_SESSION['id']));
			if($req->rowCount() == 1)
			{
				if (isset($_POST['notif'])) {
					$notif = 1;
				}
				else{
					$notif = 0;
				}
				$stmt = $bdd->prepare("UPDATE users SET login=:login, email=:email, notif=:notif WHERE id_user like :id");
				$stmt->bindParam(':login', $login);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':notif', $notif);
				$stmt->bindParam(':id', $_SESSION['id']);
				$stmt->execute();
				$_SESSION['login'] = $login;

				echo "<style>.alert { display: block!important; background-color: #568456!important;} </style>";
	         	$txt = "Setting change";
			}
			else{
				echo "<style>.alert { display: block!important; } </style>";
				$txt = "ERROR";
			}	
		}	
}
}

if (isset($_POST['change_passwd'])) {

if (isset($_POST['old_password']) 
	&& $_POST['old_password'] != "" 
	&& isset($_POST['new_password']) 
	&& $_POST['new_password'] != "")
{
		$old_passwd = htmlspecialchars($_POST['old_password']);
		$new_passwd = htmlspecialchars($_POST['new_password']);
		$old_passwd = hash("whirlpool", htmlspecialchars($old_passwd));
		$new_passwd = hash("whirlpool", htmlspecialchars($new_passwd));

		if (strlen($_POST['new_password']) < 5){
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Password too short";
		}
		else if (!preg_match("#[0-9]+#", $_POST['new_password'])){
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Password must include a number";
		}
		else if (!preg_match("#[a-zA-Z]+#", $_POST['new_password'])){
			echo "<style>.alert { display: block!important; } </style>";
			$txt = "ERROR : Password must include a letter";
		}
		else{
			$req = $bdd->prepare('SELECT * FROM users WHERE login = ? AND passwd = ?');
			$req->execute(array($_SESSION['login'] , $old_passwd));
			if($req->rowCount() == 1)
			{
				$stmt = $bdd->prepare("UPDATE users SET passwd=:passwd WHERE login like :login");
				$stmt->bindParam(':login', $_SESSION['login']);
				$stmt->bindParam(':passwd', $new_passwd);
				$stmt->execute();
				echo "<style>.alert { display: block!important; background-color: #568456!important;} </style>";
	         	$txt = "Password change";
			}
			else{
				echo "<style>.alert { display: block!important; } </style>";
				$txt = "ERROR : Password Wrong";
			}	
		}	
}
}


?>

<!DOCTYPE html>
<html id='HTML' xmlns:og="http://ogp.me/ns#" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Setting</title>
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
	<link rel="stylesheet" type="text/css" href="css/account_setting.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

</head>

<body>
<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="index.php"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			<div class="float_menu_rigth">
				<a href="index.php"><h2>HOME</h2></a>
				<a href="studio.php"><h2>STUDIO</h2></a>
				<a href="account_setting.php" class="link"><h2>SETTING</h2></a>
				<a href="php/logout.php"><h2>LOGOUT </h2></a>
			</div>
	</header>

<!-- ******* ERROR ***************** -->
	<div id="alert" class="alert">
	  <span class="closebtn">&times;</span> 
	  <p><?php echo $txt; ?></p>
	</div>

<!-- ******* FORMULAIRE ***************** -->
	<?php  
		$req_form = $bdd->prepare('SELECT * FROM users WHERE id_user = ?');
		$req_form->execute(array($_SESSION['id']));
		$value = $req_form->fetch();

		if ($value['notif'] == 1) {
			$check = "checked";
		}
		else
			$check = "";
	?>
	<section id="page_account-modify">
		<!-- Form -->
          <form method="post" action="account_setting.php" accept-charset="utf-8">

			<label for="email"><p>EMAIL</p></label>
			<br/>
			<input type="email" name="email" maxlength="40" required value="<?php echo $value['email']?>" />

			<label for="login"><p>PSEUDO</p></label>
			<br/>
			<input type="login" name="login" maxlength="40" required value="<?php echo $value['login']?>" />
			
			<br/>
			
			<input id="toggle" type="checkbox" name="notif" <?php echo $check; ?> />
  			<label for="toggle" class="toggle"><p style="    margin-top: 0px;">ACTIVE NOTIFICATION</p></label>

			<p class="delete"><a href="account_delete.php">DELETE ACCOUNT</a></p>

        	<!-- SIGN IN -->
			<input type="submit" name="go_modify_account" value="MODIFY" class="modify_submit"/>
          </form>



          <!-- Form Passwd-->
		<form action="account_setting.php" method="post" accept-charset="utf-8" style="height: 270px; margin-top: 340px;">
			
			<label for="old_password"><p>OLD PASSWORD</p></label>
			<br/>
			<input type="password" name="old_password" maxlength="20" required />

			<label for="new_password"><p>NEW PASSWORD</p></label>
			<br/>
			<input type="password" name="new_password" maxlength="20" required />
			
			<br/>

			<p class="delete"><a href="account_delete.php">DELETE ACCOUNT</a></p>

        	<!-- SIGN IN -->
			<input type="submit" name="change_passwd" value="CHANGE PASSWORD" class="modify_submit" />
          </form>

          <!-- /end Form -->
	</section>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>