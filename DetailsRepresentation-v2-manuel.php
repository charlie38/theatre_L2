<?php

$titre = 'Détails de représentation des spectacles';
include('entete.php');

//pas de récupération des spectacles depuis la BDD
echo ("
<form action=\"DetailsRepresentation-action-v2.php\" method=\"POST\">
    <label for=\"inp_spectacle\">Veuillez saisir une spectacle :</label>
    <select name=\"spectacle\">
        <option value=\"La flute enchantee\">La flute enchantee</option>
        <option value=\"Coldplay\">Coldplay</option>
        <option value=\"Lac des cygnes\">Lac des cygnes</option>
    </select>
    <br /><br />
    <input type=\"submit\" value=\"Valider\" />
    <input type=\"reset\" value=\"Annuler\" />
</form>
");

include('pied.php');

?>