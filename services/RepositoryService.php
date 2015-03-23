<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RepositoryService
 *
 * @author humanbooster
 */
class RepositoryService {
    
    private $repos;
    
    function get($id) {
        $id = strtolower($id);
        if (!isset($this->repos[$id]))
            return $this->repos[$id];
        else {
            $class = ucfirst($id) . "Repository";
            $filename = "model/" . $class . ".php";
            if (file_exists($filename)) {
                include($filename);
                $this->repos[$id] = new $class();
                return $this->repos[$id];
            }
        }
        return null;
    }
}
