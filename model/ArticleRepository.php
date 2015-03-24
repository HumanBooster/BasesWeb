<?php

/**
 * ArticleRepository will handle every transaction with the database
 *
 * @author humanbooster
 */
class ArticleRepository extends Repository {

    /**
     * Constructor for a repository
     * 
     * @param PDO $db
     */
    public function __construct(&$db) {
        parent::__construct($db, "article");
    }

    /**
     * Persist an article object into the table
     * 
     * @param object $article
     * @return int Number of modified entries
     */
    public function persist($article) {

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
