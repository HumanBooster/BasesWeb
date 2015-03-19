<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * ArticleController is the Controller of the articles
 *
 * @author humanbooster
 */
class ArticleController {
    
    private $repo;
    
    public function __construct($repo) {
        $this->repo = $repo;
    }

    /**
     * Index will show every article into a list
     * 
     * @return string HTML code of the content of page
     */
    public function indexAction() {
        // on forge la requete SQL
        $articles = $this->repo->getAll();

        $view = new View("article.index", array("articles" => $articles));
        
        return $view->getHtml();
    }
    
    /**
     * Allow the users to read an article on a given id via GET
     * 
     * @return string HTML code of the content of page
     */
    public function readAction() {
        // on récupère l'id de l'article à travers la var GET
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // on demande l'article au repo
        $article = $this->repo->get($id);

        $view = new View("article.read", array("article" => $article));
        
        return $view->getHtml();
    }

}
