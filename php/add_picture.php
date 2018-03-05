<?php 
include('connexion.php');
session_start();

	$filter = htmlspecialchars($_POST['filter']);

	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$img = base64_decode($img);
	$im = imagecreatefromstring($img);

	if ($filter == 1) {
		$stamp = imagecreatefrompng('../assets/filter/filter_1.png');
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
		$link = "../data/";
		$link .= uniqid();
		$link .= '.png';

		imagepng($im, $link);
		imagedestroy($im);

	}
	else if ($filter == 2) {
		$stamp = imagecreatefrompng('../assets/filter/filter_2.png');
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
		$link = "../data/";
		$link .= uniqid();
		$link .= '.png';

		imagepng($im, $link);
		imagedestroy($im);

	}
	else if ($filter == 3) {
		$stamp = imagecreatefrompng('../assets/filter/filter_3.png');
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
		$link = "../data/";
		$link .= uniqid();
		$link .= '.png';

		imagepng($im, $link);
		imagedestroy($im);
	}
	else{
		$link .= uniqid();
		$link .= '.png';
		file_put_contents('../data/'.$link, $img);
	}

	$req = $bdd->prepare('INSERT INTO pictures (picture, id_user) VALUES (:picture, :id_user)');
	$req->execute(array(
		'picture' => $link,
		'id_user' => $_SESSION['id']
	));


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