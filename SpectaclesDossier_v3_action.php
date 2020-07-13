<?php

	// récupération de la catégorie
	$noDossier = $_POST['noDossier'];

	//
	$titre = "Liste des catégories pour le dossier numéro $noDossier";
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT DISTINCT nomC
		FROM theatre.LesZones Z NATURAL JOIN theatre.LesSieges S NATURAL JOIN theatre.LesTickets
		WHERE noDossier = :n
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete);

	// affectation de la variable
	oci_bind_by_name ($curseur, ':n', $noDossier);

	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {

		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b>Aucune catégorie ne correspond au dossier numéro $noDossier</b></p>" ;

		}
		else {
			$cookie_name = "noDossier";
			$cookie_value = $noDossier;

			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
			// on affiche la table qui va servir a la mise en page du resultat
			echo ("
				<form action=\"SpectaclesDossier_v3_action2.php\" method=\"post\">
					<label for=\"categorie\">Séléctionnez une catégorie:</label>
					<select id=\"categorie\" name=\"categorie\">
			");

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$cat = oci_result($curseur, 1);
				echo ("<option value=\"$cat\">$cat</option>");
	
			} while ($res = oci_fetch ($curseur));
	
			echo ("
					</select>
					<br /><br />
					<input type=\"submit\" value=\"Valider\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);

	include('pied.php');

?>
