<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * ArticleRepository will handle every transaction with the database
 *
 * @author humanbooster
 */
class ArticleRepository {
    
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Returns a BO Article on a given id
     * 
     * @param int $id Id of the Article
     * @return mixed $article Returns an Article or false
     */
    function get($id) {

        // on forge la requete SQL
        $sql = "SELECT * FROM article WHERE id=" . $id;

        // on passe la requete SQL à PDO
        $statement = $this->db->query($sql);

        // on récupère le premier (et unique) résultat de la requete
        // si on a un article on l'affiche
        //if ($article = $statement->fetchObject("Article")) {
        $statement->setFetchMode(PDO::FETCH_CLASS, "Article");

        $article = $statement->fetch();

        return $article;
    }
}