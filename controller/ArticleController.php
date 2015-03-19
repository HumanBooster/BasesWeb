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

        if ($articles) {
                $nbRows = count($articles);

        // on affiche l'article 
        $html = '<h2>Liste des articles ('.$nbRows.')</h2>
        <ul>';
            foreach ($articles as $article) {
                $html .= "\n".'<li id="'. $article->id . '">'
                . '<a href="index.php?page=article_read&id='. $article->id .'">'. $article->title .'</a>'
                . '- <a href="index.php?page=article_edit&id='.$article->id.'">edit</a>'
                . '- <a href="index.php?page=article_delete&id='. $article->id .'">delete</a>'
                . '</li>';
            }
        $html .= '</ul>';

        // sinon on affiche un message d'erreur
        } else {
                $html = "<h2>Aucun article avec cet identifiant.</h2>";
        }

        $html .= '<p><a href="index.php?page=article_add">Ajouter un article</a></p>';
        
        return $html;
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

        if ($article) {

        // on affiche l'article 
            $html = '<h2>Lecture d\'un article</h2>

            <article id="'.$article->id.'">
                <h1>'. $article->title .'</h1>
                <p>'. nl2br($article->content) .'</p>
            </article>';

        // sinon on affiche un message d'erreur
        } else {
            $html = "<h2>Aucun article avec cet identifiant.</h2>";
        }
        
        return $html;
    }

}
