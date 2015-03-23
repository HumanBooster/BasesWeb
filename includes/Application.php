<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application
 *
 * @author humanbooster
 */
class Application {

    private $services;
    private $title;
    private $content;
    private $db;
    
    function __construct($db) {
        $this->db = $db;
    }

    function handleRequest() {
        // I. On récupère l'action demandée par l'utilisateur, avec retrocompatibilité
        // Controller et Entité
        $entityName = (isset($_GET['controller']) ? $_GET['controller'] : "article");
        // on retravaille le nom pour obtenir un nom de la forme "Article"
        $entityName = ucfirst(strtolower($entityName));

        // Action
        $actionName = (isset($_GET['action']) ? $_GET['action'] : "index");
        $actionName = strtolower($actionName);

        /** DEPREC - retrocompatibilité * */
        $page = (isset($_GET['page']) ? $_GET['page'] : "DEPREC");
        if ($page != "DEPREC") {
            // on nous a passé une page, gérons là mais alertons l'utilisateur
            $this->addMessage(0, "warning", "page est deprec, il faut utiliser le controller et l'action");
            switch ($page) {
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

        // III. / IV. On charge les fichiers nécessaires, et on instancie les classes de reco, controller
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
        //$repo = new $repoName($this->db);

        // on instancie le controller
        $controller = new $controllerName($this);


        // V. On regarde si l'action de controller existe, puis on la charge
        // on retravaille la var obtenue pour obtenir un nom de la forme "indexAction"
        $action = $actionName . "Action";

        // si la méthode demandée n'existe pas, remettre "index"
        if (!method_exists($controller, $action)) {
            $actionName = "index";
            $action = "indexAction";
        }

        // on stock le titre sous la forme "Article - Index"
        $this->title = $entityName . " - " . $actionName;

        // on appelle dynamiquement la méthode de controller
        $this->content = $controller->$action();
    }

    function renderResponse() {
        // le header contient le début de la page jusqu'à la balise <body>
        // on redéclare title pour le header
        $header = new View('global.header', array('title' => $this->title));
        echo $header->getHtml();


        // le menu est composé de la balise <nav> et de ses items
        $menu = new View('global.menu');
        echo $menu->getHtml();

        /* début corps de page */

        // on affiche les messages éventuels
        $this->showMessages();

        // on affiche le contenu principal de la page

        echo $this->content;

        /* fin corps de page */

        // on affiche le footer et on ferme la page html
        $footer = new View('global.footer');
        echo $footer->getHtml();
    }

    function getService($id) {
        $id = strtolower($id);
        if (isset($this->services[$id]))
            return $this->services[$id];
        else {
            $class = ucfirst($id) . "Service";
            $filename = "services/" . $class . ".php";
            if (file_exists($filename)) {
                include($filename);
                $this->services[$id] = new $class($this);
                return $this->services[$id];
            }
        }
        return null;
    }

    static private function showMessages() {
        if (isset($_SESSION['messages'])) {
            // on affiche un bloc pour chaque message
            foreach ($_SESSION['messages'] as $msg) {
                echo '<p class="message-' . $msg['type'] . '">[' . $msg['code'] . '] ' . $msg['lib'] . "</p>\n";
            }

            // du coup on peut supprimer les messages
            unset($_SESSION['messages']);
        }
    }

    // gestion des messages
    static function addMessage($code, $type, $lib) {
        $_SESSION['messages'][] = array("code" => $code, "type" => $type, "lib" => $lib);
    }

    static function addMessageRedirect($code, $type, $lib, $url = "index.php") {
        self::addMessage($code, $type, $lib);
        self::redirect($url);
    }

    static function redirect($url, $die = true) {
        header("Location: " . $url);
        if ($die)
            exit();
    }
    
    function getDb() {
        return $this->db;
    }

}
