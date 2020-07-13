<?php
// TODO: faire un menu déroulant : nom du spectacle + date de représentation avant d'afficher les résultats
// cf Categorie-test.php et Categorietest2.php
// récupération de la catégorie
$categorie = $_POST['categorie'];

//
$titre = "Liste des tickets pour la catégorie $categorie";
include('entete.php');

// construction de la requete
$requete = ("
    SELECT noSerie, nomS, dateRep, noPlace, noRang
    FROM theatre.LesTickets natural join theatre.LesSieges natural join theatre.LesZones natural join theatre.LesSpectacles
    WHERE nomC = :n
");

// analyse de la requete et association au curseur
$curseur = oci_parse ($lien, $requete) ;

// affectation de la variable
oci_bind_by_name ($curseur, ':n', $categorie);

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
        echo "<p class=\"erreur\"><b>Aucun ticket associée à cette catégorie ou catégorie inconnue</b></p>" ;

    }
    else {

        // on affiche la table qui va servir a la mise en page du resultat
        echo "<table><tr><th>Numéro de série</th><th>Spectacle</th><th>Date</th><th>Place</th><th>Rang</th></tr>" ;

        // on affiche un résultat et on passe au suivant s'il existe
        do {

            $noSerie = oci_result($curseur, 1) ;
            $nomS = oci_result($curseur, 2) ;
            $dateRep = oci_result($curseur, 3) ;
            $noPlace = oci_result($curseur, 4) ;
            $noRang = oci_result($curseur, 5) ;
            echo "<tr><td>$noSerie</td><td>$nomS</td><td>$dateRep</td><td>$noPlace</td><td>$noRang</td></tr>";

        } while (oci_fetch ($curseur));

        echo "</table>";
    }

}

// on libère le curseur
oci_free_statement($curseur);

include('pied.php');

?>
