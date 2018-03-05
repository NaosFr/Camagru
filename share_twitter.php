<?php 
include('php/connexion.php');
session_start();

if ($_SESSION['id'] == "" || $_SESSION['login'] == "") {
	echo '<script>document.location.href="index.php"</script>';
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


	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="SHARE PICTURE" />
	<meta name="twitter:site" content="@camagru" />
	<meta name="twitter:image" content='http://localhost:8888/data/'<?php echo $_GET['link'];?>' />
	
	<style type="text/css">
		
		section{
			text-align: center!important;
			justify-content: center;
			  -webkit-justify-content: center;
			  align-items: center;
			  -webkit-align-items: center;
			  display: -webkit-flex;
			  flex-direction: column;
		}
		
		img{
			margin-top: 40px;
		}
	</style>


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

	<section>
		<img src="data/<?php echo $_GET['link'];?>" alt="image" style="margin-top: 150px;"/>
		<a href="https://twitter.com/share?url=http://localhost:8888&amp;text=My%20Picture%20:&amp;hashtags=camagru" target="_blank">
	        <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
	    </a>
    </section>


</body>
</html>