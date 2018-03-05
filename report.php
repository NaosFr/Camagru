<?php 
include('php/connexion.php');
session_start();

if ($_SESSION['id'] == "" || $_SESSION['login'] == "") {
	echo '<script>document.location.href="index.php"</script>';
}


if (isset($_POST['report']) && isset($_POST['text']) && isset($_POST['name'])){

	ini_set( 'display_errors', 1 );
	error_reporting( E_ALL );

	$sujet = "REPORT account" ;
	$header = "From: report@camagru.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

	$message = '<html>
					<head>
						
						      </head>
						      <body>
						      <h1>REPORT '.$_POST['name'].' </h1>
						       <p>'.$_POST['text'].'</p>
						      </body>
						     </html>';

				mail("ncella98@gmail.com", $sujet, $message, $header);
	header('Location: index.php');
	$txt = "USER REPORT";
}
?>
<!DOCTYPE html>
<html id='HTML' xmlns:og="http://ogp.me/ns#" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - <?php echo $_SESSION['login']; ?></title>
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
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="css/report.css">

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

<!-- ******* CONTACT ************** -->

<section class="contactme">
	<!-- Div du formulaire -->
		<div id="form-div">
    	<!-- Formulaire demande d'information -->
    	<form class="form" id="form1" action="report.php" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		
    	<p class="name"><!-- name -->
       		<input name="name" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Name" id="name" required value="<?php echo $_GET['login']; ?>" />
    	</p>
      
      
    	<p class="text"><!-- text -->
       		<textarea name="text" class="validate[required,length[6,300]] feedback-input" id="comment" placeholder="Why ?" required></textarea>
    	</p>
      
    	<div class="submit"><!-- send -->
      		<input type="submit" value="REPORT" name="report" id="button-blue"/>
    	<div class="ease"></div>
		
    	</div>
    	</form>

    	<div class="exit_contact">
			<span class="cross1_contact cross_contact"></span>
			<span class="cross2_contact cross_contact"></span>
		</div>
</section>


</body>
</html>