<?php
   if(!isset($_SESSION))
      session_start();

   header('Content-Type: application/xhtml+xml; charset=utf-8');

   if (!isset ($_SESSION['login']) || !isset ($_SESSION['motdepasse'])) {
      // Si l’utilisateur/trice n’est pas connecté-e, on le renvoie à la page de connexion
      header('Status: 304');
      header('Location: connexion.php'); // redirection vers la page de connexion
      die();
   }

   require_once ('utils.php');
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
   <head>
      <meta charset="utf-8" />
      <title>
         <?php if(isset($titre))
            echo htmlspecialchars($titre) . ' - ';
         ?>
         Gestion du Théâtre
      </title>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <link href="style.css" rel="stylesheet" media="all" type="text/css" />
   </head>
   <body>
		<?php
			include_once("navigation.php");
		?>
		<h1> Gestion du Théâtre </h1>
		<?php

			if(isset($titre))
				echo '<h2>', $titre, '</h2>';

			if(!isset($ne_pas_connecter) || !$ne_pas_connecter) {
				// Si la page n'a pas demandé à ne pas se connecter, on se connecte
				Connexion ($_SESSION['login'], $_SESSION['motdepasse'], $lien, $codeerreur);

				if (!$lien) { // erreur
					echo LeMessage ($codeerreur);
					include('pied.php');
					die();
				}
			}
		?>
