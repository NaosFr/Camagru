<?php 
include('php/connexion.php');
session_start();

	if ($_SESSION['id'] != "" && $_SESSION['login'] != "")
	{
		$nav_log = '<a href="studio.php"><h2>STUDIO</h2></a>
				<a href="account_setting.php"><h2>SETTING</h2></a>
				<a href="php/logout.php"><h2>LOGOUT </h2></a>';
	}else{
		$nav_log = '<a href="account_login.php"><h2>LOGIN</h2></a>
				<a href="account_register.php"><h2>REGISTER</h2></a>';
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

</head>

<body>
<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="index.php"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			
			<div class="float_menu_rigth">
				<?php echo $nav_log; ?>
			</div>
	</header>



<!-- ******* FLUX ***************** -->
	<section class="flux_community" id="flux"></section>
	<p class="more" onclick="more()">MORE</p>
	<footer>
		<ul>
			<li><p>Facebook</p></li>
			<li><p>Twitter</p></li>
			<li><p>Instagram</p></li>
		</ul>
		<ul>
			<li><p>adm@camagru.com</p></li>
			<li><p>Ecole 42</p></li>
			<li><p>© 2018 42. All rights reserved."</p></li>
		</ul>
	</footer>
<!-- ******* JS ***************** -->
	<script type="text/javascript">

		function add_like(id) {
			var xmlhttp = new XMLHttpRequest();
	    	xmlhttp.onreadystatechange = function() {
		        if (xmlhttp.readyState == XMLHttpRequest.DONE) { 
		           if (xmlhttp.status == 200) {
		           	if (xmlhttp.responseText == 1) {
		           		document.getElementById("img_like_" + id).src="assets/icon/like_red.svg";
		           		var computerScore = document.getElementById("nb_like_" + id);
		           		var number = computerScore.innerHTML;
					    number++;
					    computerScore.innerHTML = number;
		           	}
		           	else{
		           		document.getElementById("img_like_" + id).src="assets/icon/like.svg";
		           		var computerScore = document.getElementById("nb_like_" + id);
		           		var number = computerScore.innerHTML;
					    number--;
					    computerScore.innerHTML = number;
		           	}
		           }
		           else if (xmlhttp.status == 400) {
		              alert('There was an error 400');
		           }
		           else {
		               alert('something else other than 200 was returned');
		           }
		        }
    		};
	    	xmlhttp.open("POST", "php/like.php", true);
	    	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	    	xmlhttp.send("like=" + id);
		};

		function add_comment(id){
				var xmlhttp = new XMLHttpRequest();
	    		xmlhttp.onreadystatechange = function() {
		        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
		           if (xmlhttp.status == 200) {
		           		document.getElementById("comment_" + id).innerHTML = xmlhttp.responseText;;
		           }
		           else if (xmlhttp.status == 400) {
		              alert('There was an error 400');
		           }
		           else {
		               alert('something else other than 200 was returned');
		           }
		        }
    			};
				var comment = encodeURIComponent(document.getElementById("commentadd_" + id).value);
				xmlhttp.open("POST", "php/comment.php", true);
				xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xmlhttp.send("comment=" + comment + "&id_picture=" + id);
		}

		function delete_comment(id){
				var xmlhttp = new XMLHttpRequest();
	    		xmlhttp.onreadystatechange = function() {
		        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
		           if (xmlhttp.status == 200) {
						console.log('saved');
		           }
		           else if (xmlhttp.status == 400) {
		              alert('There was an error 400');
		           }
		           else {
		               alert('something else other than 200 was returned');
		           }
		        }
    			};

				xmlhttp.open("POST", "php/del_comment.php", true);
				xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xmlhttp.send("id_comment=" + id);

				var element = document.getElementById("comment_p_" + id);
				element.parentNode.removeChild(element);
		}

		var nbr_picture = 5;
		more();

		function more(){
				var xmlhttp = new XMLHttpRequest();
	    		xmlhttp.onreadystatechange = function() {
		        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
		           if (xmlhttp.status == 200) {
						document.getElementById('flux').innerHTML = xmlhttp.responseText;
		           }
		           else if (xmlhttp.status == 400) {
		              alert('There was an error 400');
		           }
		           else {
		               alert('something else other than 200 was returned');
		           }
		        }
    			};
				xmlhttp.open("POST", "php/flux_picture.php", true);
				xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xmlhttp.send("nbr_picture=" + nbr_picture);
				nbr_picture += 5;
		};

		var bol = 0;

		function hide_show_comment(id){
			if (bol == 0) {
				document.getElementById("comment_" + id).style.display = 'block';
				bol = 1;
			}
			else{
				document.getElementById("comment_" + id).style.display = 'none';
				bol = 0;
			}
		};
	</script>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>