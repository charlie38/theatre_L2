<?php

	$titre = 'Contenu des relations fournies';
	include('entete.php');

	// définition des relations
	$lesRelations = array ("LesSpectacles", "LesRepresentations", "LesZones", "LesCategories", "LesSieges", "LesTickets", "LesDossiers");

	// définition des attributs
	$lesSchemas = array (
		"LesZones" => array("NOZONE","NOMC"),
		"LesTickets" => array("NOSERIE","NOSPEC","DATEREP","NOPLACE","NORANG","DATEEMISSION","NODOSSIER"),
		"LesCategories" => array("NOMC","PRIX"),
		"LesSieges" => array("NOPLACE","NORANG","NOZONE"),
		"LesSpectacles" => array ("NOSPEC","NOMS"),
		"LesRepresentations" => array ("NOSPEC","DATEREP"),
      "LesDossiers" => array ("NODOSSIER","MONTANT")	);

	// pour chaque relation
	foreach ($lesRelations as $uneRelation) {

		// construction de la requête
		$requete = "select * from theatre.$uneRelation ORDER BY {$lesSchemas[$uneRelation][0]}";

		// analyse de la requete et association au curseur
		$curseur = oci_parse ($lien, $requete) ;

		// execution de la requete
		oci_execute ($curseur);

		if (!($row = oci_fetch_array ($curseur, OCI_ASSOC))) {

			// le resultat est vide
			echo "<p><b>La relation ".$uneRelation." est vide </b></p>" ;

		}
		else {

			// création de la table qui va servir a la mise en page du resultat
			echo "<p><table> <tr><th> ".$uneRelation." </th></tr><tr>" ;

			foreach ($lesSchemas[$uneRelation] as $unAttr)
				echo "<td> ".$unAttr." </td>";

			echo "</tr>";

			// Affichage du resultat (non vide)
			do {
				echo "<tr>";
				foreach ($lesSchemas[$uneRelation] as $unAttr)
					echo "<td> ".$row[$unAttr]." </td>";
				echo "</tr>";
			} while ($row = oci_fetch_array ($curseur, OCI_ASSOC));

			echo "</table></p>";

		}

		oci_free_statement($curseur);

	}

	include('pied.php');
?>
