<?php
include('connexion.php');

if (isset($_POST['id_comment']) && $_POST['id_comment'] != "")
{
	$comment = htmlspecialchars($_POST['id_comment']);

	$req = $bdd->prepare('DELETE FROM comments WHERE id_comment=:id');
	$req->bindParam(':id', $comment, PDO::PARAM_INT);
	$req->execute();
}

?>