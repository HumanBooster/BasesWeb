<?php

/**
 * Application is the main class of our website
 *
 * @author humanbooster
 */
class Application {

    private $services;
    private $title;
    private $content;
    private $db;

    /**
     * Constructor of the Application on a given PDO object
     * 
     * @param PDO $db
     */
    function __construct($db) {
        $this->db = $db;
    }

    /**
     * This is the main method of our App. Will look for a controller
     * and action in GET and dispatch our request
     */
    function handleRequest() {
        // I. On récupère l'action demandée par l'utilisateur, avec retrocompatibilité
        // Controller et Entité
        $entityName = (isset($_GET['controller']) ? $_GET['controller'] : "article");
        // on retravaille le nom pour obtenir un nom de la forme "Article"
        $entityName = ucfirst(strtolower($entityName));

        // Action
        $actionName = (isset($_GET['action']) ? $_GET['action'] : "index");
        $actionName = strtolower($actionName);

        // II à IV sont maintenant dans loadDep
        $controller = $this->loadDependencies($entityName);

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

    /**
     * Push the response to output. Layout is to be found here.
     * 
     * @todo Put that somewhere else
     */
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

    /**
     * Load model entity and controller. Returns true if it can, false if it failed.
     * 
     * @param string $entityName
     * @return boolean
     */
    private function loadDependencies($entityName) {
        // load entity
        if (!$this->loadEntity($entityName))
            return false;
        
        $controllerName = $entityName . "Controller";
        return $this->loadController($controllerName);
        
        
    }

    /**
     * Try to include and load a controller
     * 
     * @param string $controllerName
     * @return Controller|boolean
     */
    private function loadController($controllerName) {

        // on inclut le controller
        /** @todo Vérifier que le fichier existe * */
        $filename = "controller/" . $controllerName . ".php";

        // on teste l'existence du fichier
        if (file_exists($filename)) {
            // on l'inclut s'il existe
            /** @todo vérifier s'il faut un include_once **/
            require($filename);

            // on l'instancie
            $controller = new $controllerName($this);

            return $controller;
       
        }
        return false;
    }
    
    /**
     * Try to include and load an entity
     * 
     * @param string $entityName
     * @return boolean
     */
    private function loadEntity($entityName) {
        $filename = "model/" . $entityName . ".php";

        // on teste l'existence du fichier
        if (file_exists($filename)) {
            // on l'inclut s'il existe
            /** @todo vérifier s'il faut un include_once **/
            require($filename);

            return true;
        }
        return false;
    }

    /**
     * Try to find/load a service - include and instance it if
     * needed, then returns it.
     * 
     * @example services/RepositoryService.php see RepositoryService for an example
     * 
     * @param string $id
     * @return object
     */
    function getService($id) {
        // id du service
        $id = strtolower($id);
        // si le service existe déjà on le retourne
        if (isset($this->services[$id]))
            return $this->services[$id];
        else {
            // sinon on le charge
            $class = ucfirst($id) . "Service";
            $filename = "services/" . $class . ".php";
            if (file_exists($filename)) {
                include($filename);
                $this->services[$id] = new $class($this);
                return $this->services[$id];
            }
        }
        // enfin, si on a rien retourné, c'est qu'on a rien trouvé
        Application::addMessage(0, "error", "Impossible de charger le service " . $id);
        return null;
    }

    /**
     * This static function will show any message stored in SESSION
     */
    static private function showMessages() {
        if (isset($_SESSION['messages'])) {

            $messages = new View("global.messages", array("messages" => $_SESSION['messages']));
            echo $messages->getHtml();
            // du coup on peut supprimer les messages
            unset($_SESSION['messages']);
        }
    }

    /**
     * Static function to add a message into the stack
     * 
     * @param int $code arbitrary error code
     * @param string $type warning|info|debug|error
     * @param string $lib message
     */
    static function addMessage($code, $type, $lib) {
        $_SESSION['messages'][] = array("code" => $code, "type" => $type, "lib" => $lib);
    }

    /**
     * Adds a message to stack and redirects to index.php or given url
     * 
     * @param int $code arbitrary error code
     * @param string $type warning|info|debug|error
     * @param string $lib message
     * @param string $url Relative or absolute ?
     */
    static function addMessageRedirect($code, $type, $lib, $url = "index.php") {
        self::addMessage($code, $type, $lib);
        self::redirect($url);
    }

    /**
     * Redirects to the given url.
     * 
     * @param type $url
     * @param type $die
     */
    static function redirect($url, $die = true) {
        header("Location: " . $url);
        if ($die)
            exit();
    }

    /**
     * Returns the PDO $db object
     * 
     * @return PDO
     */
    function &getDb() {
        return $this->db;
    }

}
