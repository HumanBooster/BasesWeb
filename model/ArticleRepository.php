<?php

/**
 * ArticleRepository will handle every transaction with the database
 *
 * @author humanbooster
 */
class ArticleRepository {

    /**
     * Stores the PDO database instance
     * 
     * @var PDO 
     */
    private $db;

    /**
     * Constructor for a repository
     * 
     * @param PDO $db
     */
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

    /**
     * Returns every article in the database
     * 
     * @return mixed Returns an array or false
     */
    public function getAll() {
        // on forge la requete SQL
        $sql = "SELECT * FROM article";

        // on passe la requete SQL à PDO
        $statement = $this->db->query($sql);

        // on récupère le premier (et unique) résultat de la requete
        // si on a un article on l'affiche
        $statement->setFetchMode(PDO::FETCH_CLASS, "Article");

        $articles = $statement->fetchAll();
        return $articles;
    }

    /**
     * Deletes an article from the database
     * 
     * @param int $id Id of an article
     * @return int Number of modified entries 
     */
    public function remove($id) {
        // si on a un id (GET ou POST), on déclenche la suppression
        $sql = "DELETE FROM article WHERE id=" . $id;

        // requete préparée PDO
        return $this->db->exec($sql);
    }

    /**
     * 
     * @param Article $article
     * @return int Number of modified entries
     */
    public function persist(Article $article) {

        // si on a un id (GET ou POST), on fait une mise à jour
        if ($article->id > 0)
            $sql = "UPDATE article SET title=:title, content=:content WHERE id=" . $article->id;
        // sinon on insère un nouvel enregistrement
        else
            $sql = "INSERT INTO article (title, content) VALUES (:title, :content)";

        // requete préparée PDO
        $statement = $this->db->prepare($sql);
        $statement->bindParam(":title", $article->title);
        $statement->bindParam(":content", $article->content);

        $result = $statement->execute();

        return $result;
    }

}
