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

        // on demande l'article au repo, on lève une erreur s'il n'existe pas
        if ($id > 0) {
            $article = $this->repo->get($id);

            if (!$article) {
                addMessageRedirect(0, "error", "Aucun article trouvé avec cet identifiant.");
            }
        }

        $view = new View("article.read", array("article" => $article));

        return $view->getHtml();
    }

    /**
     * Allow the users to delete an article on a given id via GET
     * 
     * @return string HTML code of the content of page
     */
    public function deleteAction() {
        // on récupère l'id de l'article à travers la var GET
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // on regarde si un formulaire a été soumis pour supprimer
        if (isset($_POST['confirmer'])) {

            // on regarde si un id est passé dans le formulaire, si oui il est prioritaire
            if (isset($_POST['id']) && $_POST['id'] > 0)
                $id = (int) $_POST['id'];

            $result = $this->repo->remove($id);

            // on valide et on redirige
            addMessageRedirect(0, "valid", $result . " article a été supprimé.");
        }
        // on regarde si notre formulaire a été annulé
        else if (isset($_POST['annuler'])) {
            // on ne fait rien et on redirige
            addMessageRedirect(0, "info", "La suppression a été annulée.");
        }

        // si on est jusqu'ici, il n'y a pas eu de redirection
        // il faut donc générer un formulaire
        // mais d'abord, regardons si on a un article correspondant à l'identifiant demandé
        if ($id > 0) {
            $article = $this->repo->get($id);

            if (!$article) {
                addMessageRedirect(0, "error", "Aucun article trouvé avec cet identifiant.");
            }
        }

        $view = new View("article.delete", array("article" => $article));

        return $view->getHtml();
    }

    /**
     * Allow the users to add/edit an article (needs a given id via GET to edit)
     * 
     * @return string HTML code of the content of page
     */
    public function editAction() {
        // on récupère l'id de l'article à travers la var GET
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // on regarde si un formulaire a été soumis
        if (isset($_POST['submit'])) {

            // on regarde si un id est passé dans le formulaire, si oui il est prioritaire
            if (isset($_POST['id']) && $_POST['id'] > 0)
                $id = (int) $_POST['id'];

            $article = new Article();
            $article->id = $id;
            $article->title = $_POST['title'];
            $article->content = $_POST['content'];

            $this->repo->persist($article);

            // on valide et on redirige
            addMessageRedirect(0, "valid", "Votre article a bien été ".
                    ($id>0 ? "mis à jour" : "ajouté"));
        }

        // si on est jusqu'ici, il n'y a pas eu de redirection
        // il faut donc générer un formulaire
        // mais d'abord, regardons si on a un article correspondant à l'identifiant demandé
        if ($id > 0) {
            $article = $this->repo->get($id);

            if (!$article)
                addMessageRedirect(0, "error", "Aucun article trouvé avec cet identifiant.");
        } else {
            // on instancie un nouvel article alors pour avoir quelque chose à afficher
            // dans le formulaire d'édition
            $article = new Article();
        }

        $view = new View("article.edit", array("article" => $article));

        return $view->getHtml();
    }

}
