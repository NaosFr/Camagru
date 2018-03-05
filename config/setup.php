<?php
include 'database.php';
try
{
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
	$bdd->query("DROP DATABASE IF EXISTS camagru");
	$bdd->query("CREATE DATABASE camagru");
	$bdd->query("use camagru");



	$bdd->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');

	$bdd->query('SET time_zone = "+00:00";');

	$bdd->query('CREATE TABLE `comments` (
								  `id_comment` int(11) NOT NULL,
								  `comment` text NOT NULL,
								  `id_picture` int(11) DEFAULT NULL,
								  `id_user` int(11) DEFAULT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

	$bdd->query('INSERT INTO `comments` (`id_comment`, `comment`, `id_picture`, `id_user`) VALUES
(1, "Welcome to 42", 7, 1);');

	$bdd->query('CREATE TABLE `likes` (
								  `id_like` int(11) NOT NULL,
								  `id_picture` int(11) DEFAULT NULL,
								  `id_user` int(11) DEFAULT NULL
								) ENGINE=InnoDB DEFAULT CHARSET=utf8;
								');

	$bdd->query('INSERT INTO `likes` (`id_like`, `id_picture`, `id_user`) VALUES
(1, 7, 1),
(2, 5, 1);');

	$bdd->query('CREATE TABLE `pictures` (
						  `id_picture` int(11) NOT NULL,
						  `id_user` int(11) DEFAULT NULL,
						  `date_pic` datetime DEFAULT CURRENT_TIMESTAMP,
						  `picture` text,
						  `nb_likes` int(11) DEFAULT 0
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

	$bdd->query('INSERT INTO `pictures` (`id_picture`, `id_user`, `date_pic`, `picture`, `nb_likes`) VALUES
(5, 1, "2018-02-08 13:46:12", "../data/5a7c469403901.png", 1),
(6, 1, "2018-02-08 13:46:48", "5a7c46b87c906.png", 0),
(7, 1, "2018-02-08 13:47:20", "5a7c46d8c5795.png", 1);
');

	$bdd->query('CREATE TABLE `users` (
								  `id_user` int(11) NOT NULL,
								  `email` varchar(255) DEFAULT NULL,
								  `login` varchar(255) DEFAULT NULL,
								  `passwd` varchar(300) DEFAULT NULL,
								  `confirm` int(11) DEFAULT NULL,
								  `cle` text,
								  `cle_passwd` text,
								  `notif` int(11) NOT NULL DEFAULT 1
								) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

	$bdd->query('INSERT INTO `users` (`id_user`, `email`, `login`, `passwd`, `confirm`, `cle`, `cle_passwd`, `notif`) VALUES
(1, "ncella98@gmail.com", "ncella", "8d1e214d80c712762ba521bd6a097571a31f822bf63ffd8c1cbafb8ec3e85858fcca65679b7f9f90439bac34fe0b02f7f459465220632671fe3e1a2d6999e9ff", 1, 0, NULL, 1);
');

	$bdd->query('ALTER TABLE `comments`
  								ADD PRIMARY KEY (`id_comment`);');

	$bdd->query('ALTER TABLE `likes`
  								ADD PRIMARY KEY (`id_like`);');

	$bdd->query('ALTER TABLE `pictures`
  								ADD PRIMARY KEY (`id_picture`);');

	$bdd->query('ALTER TABLE `users`
  								ADD PRIMARY KEY (`id_user`);');

	$bdd->query('ALTER TABLE `comments`
  								MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT;');

	$bdd->query('ALTER TABLE `likes`
  								MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT;');

	$bdd->query('ALTER TABLE `pictures`
  								MODIFY `id_picture` int(11) NOT NULL AUTO_INCREMENT;');

	$bdd->query('ALTER TABLE `users`
  								MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;');

	session_start();

	unset($_SESSION['id']);
	unset($_SESSION['login']);
	echo '<script>document.location.href="../index.php";</script>';
	exit();
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
        echo '<script>document.location.href="error.php";</script>';
}
?>