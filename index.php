<?php

/* initialisation avec session_start() */
require("includes/all.php");

$articleRepo = new ArticleRepository($db);
$articleController = new ArticleController($articleRepo);

$page = (isset($_GET['page']) ? $_GET['page'] : "article_list");

/* analyse de la page demandée et création des variables */

$montrerHtml = true;

switch ($page) {
    case "register":
        $titre = "Formulaire d'enregistrement";
        $pageInclue = "pages/register.php";
        break;
    case "register_traitement":
        $pageInclue = "pages/register_traitement.php";
        $montrerHtml = false;
        break;
    case "article_read":
        $html = $articleController->readAction();
        $titre = "Lecture d'un article";
        $pageInclue = "DEPREC";
        break;
    case "article_list":
        $html = $articleController->indexAction();
        $titre = "Liste des articles";
        $pageInclue = "DEPREC";
        break;
    case "article_add":
    case "article_edit":
        $titre = "Ajout/édition d'un article";
        $pageInclue = "pages/article_edit.php";
        break;
    case "article_delete":
        $titre = "Suppression d'un article";
        $pageInclue = "pages/article_delete.php";
        break;
    case "home":
    default:
        $titre = "Page d'accueil";
        $pageInclue = "pages/home.php";
        break;
}

// si cette page a un affichage graphique, tout inclure, sinon juste un script
if ($montrerHtml) {
    // le header contient le début de la page jusqu'à la balise <body>
    include("blocs/header.php");

    // le menu est composé de la balise <nav> et de ses items
    include("blocs/menu.php");

    /* début corps de page */

    // on affiche les messages éventuels
    showMessages();

    // on affiche le contenu principal de la page
    // @todo finish me
    if ($pageInclue != "DEPREC")
        include($pageInclue);
    else
        echo $html;

    /* fin corps de page */

    // on affiche le footer et on ferme la page html
    include("blocs/footer.php");
} else {
    // on inclut le script demandé
    include($pageInclue);
}
