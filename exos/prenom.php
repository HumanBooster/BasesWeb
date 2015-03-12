<?php
    $prenom1 = "Benjamin";
    $prenom2 = "Michel";
    $prenom3 = "Roland";

    $tabPrenoms = array($prenom1, $prenom2, $prenom3, "Roger");
?><!DOCTYPE html>
<html>
    <head>
    	<!-- En-tête de la page -->
        <meta charset="utf-8" />
        <title>Titre</title>
        <link rel="stylesheet" type="text/css" href="style.css">

    </head>

    <body>
        <p>Bonjour <?php echo $tabPrenoms[0]; ?> !</p>

        <?php /*foreach ($tabPrenoms as $p) {
            echo "<p>Bonjour " . $p . "! </p>";


        } */
        $tabSize = count($tabPrenoms);
        for ($i = 0; $i < $tabSize; $i++) {
            echo "<p>Bonjour " . $tabPrenoms[$i] . "! </p>";
        }
        ?>
    </body>
</html>