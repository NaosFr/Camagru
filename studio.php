<?php 
include('php/connexion.php');
session_start();

if ($_SESSION['id'] == "" || $_SESSION['login'] == "") {
	echo '<script>document.location.href="index.php"</script>';
}

if (isset($_GET['del']) && $_GET['del'] != "") {
	
	$req = $bdd->prepare('SELECT * FROM pictures WHERE id_picture=:id');
	$req->bindParam(':id', $_GET['del'], PDO::PARAM_INT);
	$req->execute();

	while ($data = $req->fetch())
	{
		$del = 'data/'.$data['picture'].'';
		unlink($del);
	}

	$req2 = $bdd->prepare('DELETE FROM pictures WHERE id_picture=:id');
	$req2->bindParam(':id', $_GET['del'], PDO::PARAM_INT);
	$req2->execute();


	$req3 = $bdd->prepare('DELETE FROM likes WHERE id_picture=:id');
	$req3->bindParam(':id', $_GET['del'], PDO::PARAM_INT);
	$req3->execute();

	$req4 = $bdd->prepare('DELETE FROM comments WHERE id_picture=:id');
	$req4->bindParam(':id', $_GET['del'], PDO::PARAM_INT);
	$req4->execute();

	header('Location: studio.php');
}

if(isset($_POST["submit"])) {

	$filter = htmlspecialchars($_POST['filter']);

	$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
	$extension_upload = strtolower(  substr(  strrchr($_FILES['fileToUpload']['name'], '.')  ,1)  );

	if ($_FILES['fileToUpload']['error'] > 0)
	{
		echo "<style>.alert { display: block!important;} </style>";
        $txt = "ERROR : not transfered";
	} 
	else if ($_FILES['fileToUpload']['size'] > 500000) 
	{
		echo "<style>.alert { display: block!important;} </style>";
        $txt = "ERROR : file to big";
	}
	
	else if (in_array($extension_upload,$extensions_valides))
	{
		$image_sizes = getimagesize($_FILES['fileToUpload']['tmp_name']);
		if ($image_sizes[0] > 1200 OR $image_sizes[1] > 1200)
		{
			echo "<style>.alert { display: block!important;} </style>";
        	$txt = "ERROR : file to big";
		}
		else
		{
			$infosfichier = pathinfo($_FILES["fileToUpload"]["tmp_name"]); 
			$name = $infosfichier['filename'];

				$bol = 0;
				if ($_FILES['fileToUpload']['type'] === 'image/jpg') {
					$link = "data/";
					$link .= uniqid();
					$link .= '.jpg';
					$bol = 1;
				}
				else if ($_FILES['fileToUpload']['type'] === 'image/jpeg') {
					$link = "data/";
					$link .= uniqid();
					$link .= '.jpeg';
					$bol = 1;
				}
				else if ($_FILES['fileToUpload']['type'] === 'image/gif') {
					$link = "data/";
					$link .= uniqid();
					$link .= '.gif';
					$bol = 1;
				}
				else if ($_FILES['fileToUpload']['type'] === 'image/png') {
					$link = "data/";
					$link .= uniqid();
					$link .= '.png';
					$bol = 1;
				}


				if ($bol == 1) {
					$im = imagecreatefromstring(file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
		
					if ($filter == 1) {
						$stamp = imagecreatefrompng('assets/filter/filter_1.png');
						$marge_right = 10;
						$marge_bottom = 10;
						$sx = imagesx($stamp);
						$sy = imagesy($stamp);
						imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
						imagepng($im, $link);
						imagedestroy($im);
					}
					else if ($filter == 2) {
						$stamp = imagecreatefrompng('assets/filter/filter_2.png');
						$marge_right = 10;
						$marge_bottom = 10;
						$sx = imagesx($stamp);
						$sy = imagesy($stamp);
						imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
						imagepng($im, $link);
						imagedestroy($im);

					}
					else if ($filter == 3) {
						$stamp = imagecreatefrompng('assets/filter/filter_3.png');
						$marge_right = 10;
						$marge_bottom = 10;
						$sx = imagesx($stamp);
						$sy = imagesy($stamp);
						imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
						imagepng($im, $link);
						imagedestroy($im);
					}
					else{
						if ($_FILES['fileToUpload']['type'] === 'image/jpg') {
							$link = "data/";
							$link .= uniqid();
							$link .= '.jpg';
						}
						else if ($_FILES['fileToUpload']['type'] === 'image/jpeg') {
							$link = "data/";
							$link .= uniqid();
							$link .= '.jpeg';
						}
						else if ($_FILES['fileToUpload']['type'] === 'image/gif') {
							$link = "data/";
							$link .= uniqid();
							$link .= '.gif';
						}
						else if ($_FILES['fileToUpload']['type'] === 'image/png') {
							$link = "data/";
							$link .= uniqid();
							$link .= '.png';
						}
						imagepng($im, $link);
						imagedestroy($im);
					}

					$link = str_replace('data/', '', $link);
					$req = $bdd->prepare('INSERT INTO pictures (picture, id_user) VALUES (:picture, :id_user)');
					$req->execute(array(
						'picture' => $link,
						'id_user' => $_SESSION['id']
					));
					
					echo "<style>.alert { display: block!important; background-color: #568456!important;} </style>";
	        		$txt = "PICTURE ADD";
				}
				else{
					echo "<style>.alert { display: block!important;} </style>";
        			$txt = "ERROR";
				}
		}
	}
	else
	{
		echo "<style>.alert { display: block!important;} </style>";
        $txt = "ERROR : it's not an accepted image";
	}
}

?>

<!DOCTYPE html>
<html id='HTML' xmlns:og="http://ogp.me/ns#" lang="fr">
<head>
	<meta charset="utf-8">
	<title>Studio - <?php echo $_SESSION['login']; ?></title>
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
	<link rel="stylesheet" type="text/css" href="css/studio.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

</head>

<body>
<!-- ******* HEADER ***************** -->
	<header class="float_menu">
			<a href="index.php"><img src="assets/icon/logo.png" alt="logo" class="logo"/></a>
			
			<div class="float_menu_rigth">
				<a href="index.php"><h2>HOME</h2></a>
				<a href="studio.php" class="link"><h2>STUDIO</h2></a>
				<a href="account_setting.php"><h2>SETTING</h2></a>
				<a href="php/logout.php"><h2>LOGOUT </h2></a>
			</div>
	</header>
<!-- ******* ERROR ***************** -->
	<div id="alert" class="alert">
	  <span class="closebtn">&times;</span> 
	  <p><?php echo $txt; ?></p>
	</div>
	
	<section class="flux_studio">
		<div class="div_camera">
			<video id="video" autoplay class="img_camera" width="640" height="480"></video>
		
			<img src="assets/filter/filter_1.png" alt="filter" class="filter_view" id="filter_view_1" />
			<img src="assets/filter/filter_2.png" alt="filter" class="filter_view" id="filter_view_2" />
			<img src="assets/filter/filter_3.png" alt="filter" class="filter_view" id="filter_view_3" />
		
			<img src="assets/icon/camera.svg" alt="camera" class="camera" onclick="camera_send()" />
			
			<form action="studio.php" method="post" enctype="multipart/form-data" class="form_camera" id="searchForm">
				<input id="filter_1" type="radio" name="filter" value="1">
				<input id="filter_2" type="radio" name="filter" value="2">
				<input id="filter_3" type="radio" name="filter" value="3">
       			<input type="file" accept="image/*" capture="camera" id="camera_file" name="fileToUpload" onchange="file_send()"/>
     			<input type="submit" name="submit" value="submit" id="camera_send"/>	
			</form>

			<img src="assets/filter/filter_1.png" alt="filter" class="filter" onclick="filter_send(1)" />
			<img src="assets/filter/filter_2.png" alt="filter" class="filter" onclick="filter_send(2)" />
			<img src="assets/filter/filter_3.png" alt="filter" class="filter" onclick="filter_send(3)" />

			<form method="POST" name="form" id="form" onsubmit="return false">
				<input id="filter_1" type="radio" name="filter" value="1">
				<input id="filter_2" type="radio" name="filter" value="2">
				<input id="filter_3" type="radio" name="filter" value="3">
				<textarea name="base64" id="base64"></textarea>
				<button type="submit" id="send">Send image</button>
			</form>

			<img src="assets/icon/import.svg" alt="import" class="import" id="import" onclick="camera_file()" />
		</div>

		<div class="flux_picture_user" id="flux_picture_user">
		<?php 
			$req = $bdd->prepare('SELECT * FROM pictures WHERE id_user = ? ORDER BY date_pic DESC');
			$req->execute(array($_SESSION['id']));

			while ($data = $req->fetch())
			{

    			echo '<div class="my_pictcure" id="' . $data['id_picture'] . '">
    						<img src="data/'.$data['picture'].'" alt="img" class="my_img_picture" />
							<img src="assets/icon/garbage.svg" alt="garbage" class="garbage" onclick="delete_picture(' . $data['id_picture'] . ')"/>
					</div>';
			}

		?>
		</div>
	</section>

	<canvas id="myCanvasImage" width="640" height="480"></canvas>
	
	<!-- ******* JS ***************** -->
	<script type="text/javascript">

	/////// CAMERA 

	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
	    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	    });
	}

	function camera_send(){
		var button = document.getElementById("send");
		button.click();
	}

	document.getElementById('form').addEventListener("submit",function(){
	    var radios = document.getElementsByName('filter');
		for (var i = 0, length = radios.length; i < length; i++)
		{
		 if (radios[i].checked)
		 {
		  var filter =radios[i].value;
		  break;
		 }
		}
	    var canvas = document.getElementById("myCanvasImage");
	    context = canvas.getContext('2d');
	    context.drawImage(video, 0, 0, 640, 480);  
	    var image = canvas.toDataURL();

	    var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == XMLHttpRequest.DONE) {
			if (xmlhttp.status == 200) {
				document.getElementById('flux_picture_user').innerHTML = xmlhttp.responseText;
			    //console.log(xmlhttp.responseText);
			    // document.location.href="studio.php";
			}
			// else if (xmlhttp.status == 400) {
			//     console.log('There was an error 400');
			// }
			// else {
			//     console.log('something else other than 200 was returned');
			// }
		}
	    };

	    xmlhttp.open("POST", "php/add_picture.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("img=" + image + "&filter=" + filter);
   	},false);

	</script>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>


