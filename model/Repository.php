<?php

/**
 * Repository is the top level class for database interactions
 *
 * @author humanbooster
 */
abstract class Repository {

    /**
     * Stores the PDO database instance
     * 
     * @var PDO 
     */
    protected $db;
    
    /**
     * Stores the table name
     * 
     * @var string
     */
    protected $table;

    /**
     * Constructor for a generic repository
     * 
     * @param PDO $db
     */
    public function __construct(&$db, $table) {
        $this->db = $db;
        $this->table = $table;
    }

    /**
     * Returns a BO of the given class on a given id
     * 
     * @param int $id Id of the BO
     * @return mixed|boolean $object Returns a BO or false
     */
    function get($id) {

        // on forge la requete SQL
        $sql = "SELECT * FROM ".$this->table." WHERE id=" . $id;

        // on passe la requete SQL à PDO
        $statement = $this->db->query($sql);

        // on récupère le premier (et unique) résultat de la requete
        //$statement->setFetchMode(PDO::FETCH_CLASS, ucfirst($this->table));

        $assoc = $statement->fetch();
        
        $class = ucfirst($this->table);
        
        $object = new $class();
        $object->bind($assoc);
        
        return $object;
    }

    /**
     * Returns every object in the table
     * 
     * @return mixed $objects Returns an array or false
     */
    public function getAll() {
        // on forge la requete SQL
        $sql = "SELECT * FROM ".$this->table;

        // on passe la requete SQL à PDO
        $statement = $this->db->query($sql);

        // on récupère le premier (et unique) résultat de la requete
        // si on a un article on l'affiche
        $statement->setFetchMode(PDO::FETCH_CLASS, ucfirst($this->table));

        $objects = $statement->fetchAll();
        return $objects;
    }

    /**
     * Deletes an object from the database
     * 
     * @param int $id Id of an article
     * @return int Number of modified entries 
     */
    public function remove($id) {
        // si on a un id (GET ou POST), on déclenche la suppression
        $sql = "DELETE FROM ".$this->table." WHERE id=" . $id;

        // requete préparée PDO
        return $this->db->exec($sql);
    }

    /**
     * 
     * @param mixed $object Business Object
     * @return int Number of modified entries
     */
    public abstract function persist($object);

}
