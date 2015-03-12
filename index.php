<?php

$page = (isset($_GET['page']) ? $_GET['page'] : "home");

session_start();

require("includes/functions.php");

$title = "Formulaire d'enregistrement";

include("blocs/header.php");

include("blocs/menu.php");

// début corps de page
showMessages();

switch ($page) {
    case "register":
        include("pages/register.php");
        break;
    case "register_traitement":
        include("pages/register_traitement.php");
        break;
    case "home":
    default:
        include("pages/home.php");
        break;
}

// fin corps de page

include("blocs/footer.php");