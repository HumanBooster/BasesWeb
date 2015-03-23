<?php

/* initialisation avec session_start() */
require("includes/all.php");

$app = new Application($db);

// I. à V. on traite la requete
$app->handleRequest();

// VI. On déclenche l'affichage de la page

// plus besoin de tester l'affichage vu que les redirection empêcheront
// d'atteindre le return dans le controller

$app->renderResponse();
