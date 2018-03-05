<?php 
include('connexion.php');
	
	$nbr_picture = htmlspecialchars($_POST['nbr_picture']);

	if ($nbr_picture == 0) {
		$nbr_picture = 5;
	}

	if ($_SESSION['id'] != "") {

			$req = $bdd->prepare('SELECT * FROM pictures ORDER BY date_pic DESC LIMIT '.$nbr_picture.'');
			$req->execute();

			while ($data = $req->fetch())
			{
				$req_login = $bdd->prepare('SELECT login FROM users WHERE id_user = '.$data['id_user'].'');
				$req_login->execute();
				$data_login = $req_login->fetch();

				$req2 = $bdd->prepare('SELECT * FROM comments WHERE id_picture = '.$data['id_picture'].'');
				$req2->execute();


				$req_like = $bdd->prepare('SELECT id_like FROM likes WHERE id_picture = '.$data['id_picture'].' AND id_user = '.$_SESSION['id'].'');
				$req_like->execute();

				echo '<div class="pictcure" id="'.$data['id_picture'].'">
						<img src="data/'.$data['picture'].'" alt="img" class="img_picture" />';
				
				if($req_like->rowCount() == 1)
				{
					echo '<img src="assets/icon/like_red.svg" id="img_like_'.$data['id_picture'].'" alt="like" class="like" onclick="add_like('.$data['id_picture'].')"/>';
				}	
				else{
					echo '<img src="assets/icon/like.svg" id="img_like_'.$data['id_picture'].'" alt="like" class="like" onclick="add_like('.$data['id_picture'].')"/>';
				}

				echo '<p class="report"><a href="report.php?login='.$data_login['login'].'">REPORT</a></p>

				<p class="twitter"><a href="share_twitter.php?link='.$data['picture'].'">TWITTER</a></p>

				<p class="nb_like" id="nb_like_'.$data['id_picture'].'">'.$data['nb_likes'].'</p>
						<p class="login">'.$data_login['login'].'</p>
						<img src="assets/icon/chat.svg" alt="chat" class="chat" onclick="hide_show_comment('.$data['id_picture'].')"/>
						<div class="comment" id="comment_'.$data['id_picture'].'">';
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
							<input type="text" name="comment" required id="commentadd_'.$data['id_picture'].'" />
				      		<input name="submit" type="submit" value="COMMENT"  onclick="add_comment('.$data['id_picture'].')" />
						</form>
					</div>
					</div>';
			}
		}
		else{
			$req = $bdd->prepare('SELECT * FROM pictures ORDER BY date_pic DESC LIMIT '.$nbr_picture.'');
			$req->execute();

			while ($data = $req->fetch())
			{
				$req_login = $bdd->prepare('SELECT login FROM users WHERE id_user = '.$data['id_user'].'');
				$req_login->execute();
				$data_login = $req_login->fetch();

				$req2 = $bdd->prepare('SELECT * FROM comments WHERE id_picture = '.$data['id_picture'].'');
				$req2->execute();

				echo '<div class="pictcure" id="' . $data['id_picture'] . '">
						<img src="data/'.$data['picture'].'" alt="img" class="img_picture" />';
				echo '<img src="assets/icon/like.svg" alt="like" class="like"/>';

				echo '
						<p class="nb_like">'.$data['nb_likes'].'</p>
						<p class="login">'.$data_login['login'].'</p>
						<img src="assets/icon/chat.svg" alt="chat" class="chat" onclick="hide_show_comment('.$data['id_picture'].')"/>
						<div class="comment" id="comment_'.$data['id_picture'].'">';
					
					while ($data_comment = $req2->fetch())
					{
						$req2_login = $bdd->prepare('SELECT login FROM users WHERE id_user = '.$data_comment['id_user'].'');
						$req2_login->execute();
						$data2_login = $req2_login->fetch();

						echo '<p><span>'.$data2_login['login'].' : </span>'.$data_comment['comment'].'';
						echo '</p>';
					}
				echo '
					</div>
					</div>';
			}
		}

?>