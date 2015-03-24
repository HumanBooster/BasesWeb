<?php

/**
 * UserRepository will handle every transaction with the database
 *
 * @author humanbooster
 */
class UserRepository extends Repository {

    /**
     * Constructor for a repository
     * 
     * @param PDO $db
     */
    public function __construct($db) {
        parent::__construct($db, "user");
    }

    /**
     * 
     * @param object $user
     * @return int Number of modified entries
     */
    public function persist($user) {

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
