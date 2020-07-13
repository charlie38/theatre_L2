<?php

	$titre = 'Liste des places associées au dossier 11 pour une catégorie donnée';
	include('entete.php');

	// affichage du formulaire
	echo ("
		<form action=\"SpectaclesDossier_v1_action.php\" method=\"POST\">
			<label for=\"inp_categorie\">Veuillez saisir une catégorie :</label>
			<select name=\"categorie\">
				<option value=\"1er balcon\">1er balcon</option>
				<option value=\"2nd balcon\">2nd balcon</option>
				<option value=\"orchestre\">orchestre</option>
				<option value=\"poulailler\">poulailler</option>
			</select>
			<br /><br />
			<input type=\"submit\" value=\"Valider\" />
			<input type=\"reset\" value=\"Annuler\" />
		</form>
	");

	// travail à réaliser
	// echo ("
	// 	<p class=\"work\">
	// 		Améliorez l'interface utilisateur en proposant, à la place du champ de saisie libre, un choix de catégorie dans une liste contenant toutes les catégories (sous forme de boite de sélection ou de boutons radio).<br />Cette liste sera codée \"en dur\".
	// 	</p>
	// ");

	include('pied.php');

?>
