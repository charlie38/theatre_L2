<?php
	$titre = 'Relations appartenant au compte ' . $login;
	include('entete.php');

	// construction de la requete
	$requete = "select table_name from tabs ";

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	oci_execute ($curseur) ;

	$res = oci_fetch ($curseur);

	if ( !$res) {
		// le resultat est vide
		echo "<p class=\"erreur\"><b>Aucune relation </b></p>" ;
	}
	else {
		// la table qui va servir a la mise en page du resultat
		echo "<table> <tr><th> Nom relation </th></tr>" ;

		// Affichage du resultat (non vide)
		do {    $nomRel = oci_result($curseur,1) ;
			echo "<tr><td> $nomRel </td></tr>";
		} while (oci_fetch ($curseur));
		echo "</table>";
	}
	oci_free_statement($curseur);

	include('pied.php');
?>
