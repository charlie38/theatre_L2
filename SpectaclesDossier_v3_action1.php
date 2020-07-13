<?php

	// récupération de la catégorie
	session_start();
	$_SESSION['noDossier'] = $_POST['noDossier'];
	$noDossier = $_SESSION['noDossier'];
	$categorie = $_POST['categorie'];

	//
	$titre = "Liste des places associées au dossier 11 pour la catégorie $categorie";
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT DISTINCT nomC
        FROM theatre.LesZones natural join theatre.LesSieges natural join theatre.LesTickets
        WHERE noDossier =:n"
	);

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

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
			echo "<p class=\"erreur\"><b>Aucune place disponible pour ce numéro de dossier ou dossier inconnu</b></p>" ;

		}
		else {

			echo ("
				<form action=\"SpectaclesDossier_v3_action2.php\" method=\"post\">
					<label for=\"categorie\">Séléctionnez une catégorie:</label>
					<select id=\"categorie\" name=\"categorie\">
            ");
            
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
