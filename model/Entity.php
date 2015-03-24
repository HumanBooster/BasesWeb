<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Entity is the top level class of every entity/business object
 *
 * @author humanbooster
 */
class Entity {

    /**
     * Will bind an assoc array to an object
     * will also try to convert underscore to camelCase
     * 
     * @param array $post Associative array
     */
    public function bind($post) {
        // on définit des clés à sauter ici
        $noBind = array("email_confirm", "password_confirm", "submit");
        
        // on boucle sur le tableau associatif et on récupère cle et valeur
        foreach ($post as $key => $value) {
            // on saute les clés à ne pas binder
            if (in_array($key, $noBind))
                    continue; // continue passe à la prochaine occurence de la boucle
            
            // on cherche une propriete identique à la clé
            if (property_exists(get_class($this), $key)) {
                // si on trouve, on lui assigne la valeur
                $this->$key = $value;
                //echo "\n Found key " . $key;
            } else {
                // on convertis la clé vers du camelCase
                $camelKey = us2cc($key);
                //echo "\n".$key ." => " .$camelKey;
                if (property_exists(get_class($this), $camelKey)) {
                    // si on trouve, on lui assigne la valeur
                    $this->$camelKey = $value;
                } else {
                    // sinon on signale au développeur qu'un champ est mal formé
                    Application::addMessage(0, "error", "No key found in object for key : " . $key . " or " . $camelKey . " !");
                }
            }
        }
    }
    
    /**
     * Returns the object as an assoc array, friendly for DB storage
     * 
     * @param boolean $putId Default on false, set on true to include the id key
     * @return array Assoc array with underscore to store in database
     */
    public function getAssoc($putId = false) {
        // on récupère les variables de l'objet
        $objectVars = get_object_vars($this);
        // on boucle sur clé et valeur
        foreach( $objectVars as $key => $value) {
            // on saute l'id, à moins que putId soit vrai
            if (($key!="id")||($putId))
                // on convertit la clé en underscore pour stocker la valeur
                $result[cc2us($key)] = $value;
        }
        return $result;
    }

}
