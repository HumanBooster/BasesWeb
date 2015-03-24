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
        // on boucle sur le tableau associatif et on récupère cle et valeur
        foreach ($post as $key => $value) {
            // on cherche une propriete identique à la clé
            if (property_exists(get_class($this), $key)) {
                // si on trouve, on lui assigne la valeur
                $this->$key = $value;
                //echo "\n Found key " . $key;
            } else {
                // on convertis la clé vers du camelCase
                $camelKey = $this->us2cc($key);
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
                $result[$this->cc2us($key)] = $value;
        }
        return $result;
    }

    /**
     * Underscore to camelCase
     * 
     * @param string $str String to convert
     * @return string Converted string to camelCase
     */
    public static function us2cc($str) {
        // si la chaine ne contient pas de "_", on la renvoie telle quelle
        if (strpos($str, "_") === false)
            return $str;

        // sinon on explose la chaine dans un tableau
        // autour du délimiteur "_"
        $words = explode("_", $str);

        // le compteur permet de différencier le premier mot (0)
        $count = 0;
        // puis on concatène en camelCase
        foreach ($words as $word) {
            // premier mot ) prendre tel quel
            if ($count == 0)
                $result = $word;
            // mots suivants à capitaliser
            else
                $result .= ucfirst($word);
            $count++;
        }
        return $result;
    }

    /**
     * CamelCase to Underscore
     * 
     * @param string $str camelCase string to convert
     * @return string string converted to underscore
     */
    public static function cc2us($str) {
        // this is clearly black magic !
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

}
