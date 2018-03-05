<?php
include('connexion.php');

if(isset($_POST['id_picture']) && isset($_POST['comment'])) {

    $idpicture = htmlspecialchars($_POST['id_picture']);
    $iduser = htmlspecialchars($_SESSION['id']);
    $comment = htmlspecialchars($_POST['comment']);

    $req = $bdd->prepare('INSERT INTO comments (comment, id_picture, id_user) VALUES (:comment, :id_picture, :id_user)');
    $req->execute(array(
        'comment' => $comment,
        'id_picture' => $idpicture,
        'id_user' => $iduser
    ));

    $req2 = $bdd->prepare('SELECT * FROM comments WHERE id_picture = '.$idpicture.'');
	$req2->execute();
	while ($data_comment = $req2->fetch())
	{
		$req2_login = $bdd->prepare('SELECT login FROM users WHERE id_user = '.$data_comment['id_user'].'');
		$req2_login->execute();
		$data2_login = $req2_login->fetch();

		echo '<p id="comment_p_'.$data_comment['id_comment'].'"><span>'.$data2_login['login'].' : </span>'.$data_comment['comment'].'';
		if ($_SESSION['id'] === $data_comment['id_user']) {
			echo '<img src="assets/icon/garbage.svg" alt="trash" class="del_comment"  onclick="delete_comment(' . $data_comment['id_comment'] . ')"/>';
		}	
		echo '</p>';
	}
	echo '<form action="#" onsubmit="return false">
							<input type="text" name="comment" required id="commentadd_'.$idpicture.'" />
				      		<input name="submit" type="submit" value="COMMENT"  onclick="add_comment('.$idpicture.')" />
						</form>';


	$req3 = $bdd->prepare('SELECT id_user FROM pictures WHERE id_picture = '.$idpicture.'');
	$req3->execute();
	$id = $req3->fetch();

	$req4 = $bdd->prepare('SELECT email, notif FROM users WHERE id_user=:id');
	$req4->bindParam(':id', $id['id_user']);
	$req4->execute();
	$login = $req4->fetch();

	if ($login['notif'] == 1) {
		ini_set( 'display_errors', 1 );
		error_reporting( E_ALL );

		$sujet = "Notif camagru" ;
		$header = "From: adm@camagru.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

		$message = '<html>
						<head>
							<title>Welcome to Camagru</title>
						</head>
						<body>
							<img src="http://localhost:8888/assets/icon/logo2.png" style="width: 100px;">
							<p>your picture was commented<br>------------------------------------------------------------------------------------------<br>This is an automatic email, please do not reply.</p>
						</body>
					</html>';

		mail($login['email'], $sujet, $message, $header);
	}
}

?>