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
    private $app;
    
    function __construct(Application $app) {
        $this->app = $app;
    }
    
    function get($id) {
        $id = strtolower($id);
        if (isset($this->repos[$id]))
            return $this->repos[$id];
        else {
            $class = ucfirst($id) . "Repository";
            $filename = "model/" . $class . ".php";
            if (file_exists($filename)) {
                include_once($filename);
                $this->repos[$id] = new $class($this->app->getDb());
                return $this->repos[$id];
            }
        }
        return null;
    }
}
