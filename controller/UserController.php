<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * UserController is the Controller of the users
 *
 * @author humanbooster
 */
class UserController extends Controller {
    
    /**
     * Index action will show every user into a list
     * 
     * @return string HTML code of the content of page
     */
    public function indexAction() {
        // on forge la requete SQL
        $repo = $this->getRepository("user");
        $users = $repo->getAll();

        $view = new View("user.index", array("users" => $users));

        return $view->getHtml();
    }

    /**
     * Action that allows the users to read an user on a given id via GET
     * 
     * @return string HTML code of the content of page
     */
    public function readAction() {
        // on récupère l'id de l'user à travers la var GET
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // on demande l'user au repo, on lève une erreur s'il n'existe pas
        if ($id > 0) {
            $user = $this->getRepository("user")->get($id);

            if (!$user) {
                Application::addMessageRedirect(0, "error", "Aucun user trouvé avec cet identifiant.");
            }
        }

        $view = new View("user.read", array("user" => $user));

        return $view->getHtml();
    }

    /**
     * Allow the users to delete an user on a given id via GET
     * 
     * @return string HTML code of the content of page
     */
    public function deleteAction() {
        // on récupère l'id de l'user à travers la var GET
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // on regarde si un formulaire a été soumis pour supprimer
        if (isset($_POST['confirmer'])) {

            // on regarde si un id est passé dans le formulaire, si oui il est prioritaire
            if (isset($_POST['id']) && $_POST['id'] > 0)
                $id = (int) $_POST['id'];

            $result = $this->getRepository("user")->remove($id);

            // on valide et on redirige
            Application::addMessageRedirect(0, "valid", $result . " user a été supprimé.");
        }
        // on regarde si notre formulaire a été annulé
        else if (isset($_POST['annuler'])) {
            // on ne fait rien et on redirige
            Application::addMessageRedirect(0, "info", "La suppression a été annulée.");
        }

        // si on est jusqu'ici, il n'y a pas eu de redirection
        // il faut donc générer un formulaire
        // mais d'abord, regardons si on a un user correspondant à l'identifiant demandé
        if ($id > 0) {
            $user = $this->getRepository("user")->get($id);

            if (!$user) {
                Application::addMessageRedirect(0, "error", "Aucun utilisateur trouvé avec cet identifiant.");
            }
        }

        $view = new View("user.delete", array("user" => $user));

        return $view->getHtml();
    }

    /**
     * Allow the users to add/edit an user (needs a given id via GET to edit)
     * 
     * @return string HTML code of the content of page
     */
    public function editAction() {
        // on récupère l'id de l'user à travers la var GET
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        // on regarde si un formulaire a été soumis
        if (isset($_POST['submit'])) {

            // on regarde si un id est passé dans le formulaire, si oui il est prioritaire
            if (isset($_POST['id']) && $_POST['id'] > 0)
                $id = (int) $_POST['id'];

            $user = new User();
            $user->bind($_POST);
            
            // add a register date
            if ($id==0) { // signifie nouvelle entrée
                $user->registerDate = date('Y-m-d H:i:s');
            }

            $this->getRepository("user")->persist($user);

            // on valide et on redirige
            Application::addMessageRedirect(0, "valid", "L'utilisateur a bien été ".
                    ($id>0 ? "mis à jour" : "ajouté"), "index.php?controller=user");
        }

        // si on est jusqu'ici, il n'y a pas eu de redirection
        // il faut donc générer un formulaire
        // mais d'abord, regardons si on a un user correspondant à l'identifiant demandé
        if ($id > 0) {
            $user = $this->getRepository("user")->get($id);

            if (!$user)
                Application::addMessageRedirect(0, "error", "Aucun utilisateur trouvé avec cet identifiant.");
        } else {
            // on instancie un nouvel user alors pour avoir quelque chose à afficher
            // dans le formulaire d'édition
            $user = new User();
        }

        $view = new View("user.edit", array("user" => $user));

        return $view->getHtml();
    }

}
