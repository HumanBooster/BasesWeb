<?php

/* initialisation avec session_start() */
require("includes/all.php");


// I. On récupère l'action demandée par l'utilisateur, avec retrocompatibilité

// Controller et Entité
$entityName = (isset($_GET['controller']) ? $_GET['controller'] : "article");
// on retravaille le nom pour obtenir un nom de la forme "Article"
$entityName = ucfirst(strtolower($entityName));

// Action
$actionName = (isset($_GET['action']) ? $_GET['action'] : "index");
$actionName = strtolower($actionName);

/** DEPREC - retrocompatibilité **/
$page = (isset($_GET['page']) ? $_GET['page'] : "DEPREC");
if ($page != "DEPREC") {
    // on nous a passé une page, gérons là mais alertons l'utilisateur
    addMessage(0, "warning", "page est deprec, il faut utiliser le controller et l'action");
    switch($page) {
        case "article_read":
            $entityName = "Article";
            $actionName = "read";
            break;
        case "article_delete":
            $entityName = "Article";
            $actionName = "delete";
            break;
        case "article_add":
        case "article_edit":
            $entityName = "Article";
            $actionName = "edit";
            break;
        case "article_list":
            $entityName = "Article";
            $actionName = "index";
            break;   
    }
}

// II. On charge les fichiers nécessaires, et on instancie les classes de reco, controller

// on retravaille la var obtenue pour obtenir un nom de la forme "ArticleController"
$controllerName = $entityName . "Controller";
// on inclut le controller
include("controller/" . $controllerName . ".php");
// on inclut l'entité
include("model/" . $entityName . ".php");

// Repo - @todo Utiliser un gestionnaire de repo et les charger
// depuis les actions de controller
$repoName = ucfirst(strtolower($entityName)) . "Repository";
include("model/" . $repoName . ".php");


// on instancie un nouveau repo
$repo = new $repoName($db);

// on instancie le controller
$controller = new $controllerName($repo);


// III. On regarde si l'action de controller existe, puis on la charge

// on retravaille la var obtenue pour obtenir un nom de la forme "indexAction"
$action = $actionName . "Action";

// si la méthode demandée n'existe pas, remettre "index"
if (!method_exists($controller, $action)) {
    $actionName = "index";
    $action = "indexAction";
}

// on stock le titre sous la forme "Article - Index"
$titre = $entityName . " - " . $actionName;

// on appelle dynamiquement la méthode de controller
$html = $controller->$action();

// IV. On déclenche l'affichage de la page

// plus besoin de tester l'affichage vu que les redirection empêcheront
// d'atteindre le return dans le controller

// le header contient le début de la page jusqu'à la balise <body>
include("blocs/header.php");

// le menu est composé de la balise <nav> et de ses items
include("blocs/menu.php");

/* début corps de page */

// on affiche les messages éventuels
showMessages();

// on affiche le contenu principal de la page
echo $html;

/* fin corps de page */

// on affiche le footer et on ferme la page html
include("blocs/footer.php");
