<?php

/**
 * UserRepository will handle every transaction with the database
 *
 * @author humanbooster
 */
class UserRepository {

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
     * Returns a BO User on a given id
     * 
     * @param int $id Id of the Article
     * @return mixed|boolean $article Returns an Article or false
     */
    function get($id) {

        // on forge la requete SQL
        $sql = "SELECT * FROM user WHERE id=" . $id;

        // on passe la requete SQL à PDO
        $statement = $this->db->query($sql);

        // on récupère le premier (et unique) résultat de la requete
        // si on a un article on l'affiche
        $statement->setFetchMode(PDO::FETCH_CLASS, "User");

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
        $sql = "SELECT * FROM user";

        // on passe la requete SQL à PDO
        $statement = $this->db->query($sql);

        // on récupère le premier (et unique) résultat de la requete
        // si on a un article on l'affiche
        $statement->setFetchMode(PDO::FETCH_CLASS, "User");

        $articles = $statement->fetchAll();
        return $articles;
    }

    /**
     * Deletes a user from the database
     * 
     * @param int $id Id of an user
     * @return int Number of modified entries 
     */
    public function remove($id) {
        // si on a un id (GET ou POST), on déclenche la suppression
        $sql = "DELETE FROM user WHERE id=" . $id;

        // requete préparée PDO
        return $this->db->exec($sql);
    }

    /**
     * 
     * @param User $user
     * @return int Number of modified entries
     */
    public function persist(User $user) {

        // si on a un id (GET ou POST), on fait une mise à jour
        if ($user->id > 0)
            $sql = "UPDATE user SET login=:login, email=:email, password=:password,"
                . " name=:name, birth_date=:birth_date, register_date=:register_date,"
                . " last_login_date=:last_login_date WHERE id=" . $user->id;
        // sinon on insère un nouvel enregistrement
        else
            $sql = "INSERT INTO user (login, email, password, name, birth_date, register_date, last_login_date)"
                . " VALUES (:login, :email, :password, :name, :birth_date, :register_date, :last_login_date)";

        // requete préparée PDO
        $statement = $this->db->prepare($sql);
        $statement->bindParam(":login", $user->login);
        $statement->bindParam(":email", $user->email);
        $statement->bindParam(":password", $user->password);
        $statement->bindParam(":name", $user->name);
        $statement->bindParam(":birth_date", $user->birth_date);
        $statement->bindParam(":register_date", $user->register_date);
        $statement->bindParam(":last_login_date", $user->last_login_date);
        
        $result = $statement->execute();

        return $result;
    }

}
