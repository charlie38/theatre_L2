<?php

$titre = 'Détails des représentations';
include('entete.php');

// construction de la requete
$requete = ("
	SELECT DISTINCT S.nomS, S.nospec
	FROM theatre.LesRepresentations R JOIN theatre.LesSpectacles S ON (S.nospec = R.nospec)
");

// analyse de la requete et association au curseur
$curseur = oci_parse ($lien, $requete) ;

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
		echo "<p class=\"erreur\"><b> Spectacle inconnu </b></p>" ;

	}
	else {

		// on affiche la table qui va servir a la mise en page du resultat
		echo "
			<h2>Veuillez choisir un spectable pour obtenir des détails:</h2>
			
		" ;

		// on affiche un résultat et on passe au suivant s'il existe
		echo "
			<form action=\"DetailsRepresentation-action.php\" method=\"post\">
				<select id=\"noSpec\" name=\"noSpec\">
		";

		do {
            $nomS    = oci_result($curseur,1) ;
            $nospec    = oci_result($curseur,2) ;

			echo "
				<option value='$nospec'> $nomS </option>
			";
		} while (oci_fetch ($curseur));

		echo "
                </select>
                <br /><br />
				<input type=\"submit\" value=\"Valider\" />
				<input type=\"reset\" value=\"Annuler\" />
			</form>
		";


		
	}

}

// on libère le curseur
oci_free_statement($curseur);

include('pied.php');

?>

