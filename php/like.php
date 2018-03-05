<?php

include('connexion.php');
if(isset($_POST['like'])) {

    $idpicture = htmlspecialchars($_POST['like']);
    $iduser = htmlspecialchars($_SESSION['id']);


    $req = $bdd->prepare('SELECT id_like FROM likes WHERE id_picture = ? AND id_user = ?');
    $req->execute(array($idpicture, $iduser));

    $resultat = $req->fetch();

    if (!$resultat) {
        $reqins = $bdd->query('INSERT INTO likes(id_picture, id_user) VALUES (\''.$idpicture.'\', \''.$iduser.'\')'); 
        $requp = $bdd->query('UPDATE pictures SET nb_likes = nb_likes + 1 WHERE id_picture = '.$idpicture.'');
        echo "1";
      
    } else {
        $reqbs = $bdd->query('UPDATE pictures SET nb_likes = nb_likes - 1 WHERE id_picture = '.$idpicture.'');
        $req2 = $bdd->prepare('DELETE FROM likes WHERE id_picture=:idpicture AND id_user=:iduser');
        $req2->bindParam(':idpicture', $idpicture, PDO::PARAM_INT);
        $req2->bindParam(':iduser', $iduser, PDO::PARAM_INT);
        $req2->execute();
        echo "-1";
      
    }
}

?>