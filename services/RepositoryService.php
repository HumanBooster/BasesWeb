<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * RepositoryService will helps you to get any existing repository
 *
 * @author humanbooster
 */
class RepositoryService {
    
    /**
     * Will store a declared repository (~Singleton)
     * 
     * @var Repository[]
     */
    private $repos;
    
    /**
     * Stores the application (according to the Dependency Injection Pattern)
     * 
     * @var Application 
     */
    private $app;
    
    /** 
     * Constructor for the service (according to the Dependency Injection Pattern)
     * 
     * @param Application $app
     */
    function __construct(Application $app) {
        $this->app = $app;
    }
    
    /**
     * Try to find/load a repository for a given entity
     * 
     * @param string $entity
     * @return Repository 
     */
    function get($entity) {
        $entity = strtolower($entity);
        if (isset($this->repos[$entity]))
            return $this->repos[$entity];
        else {
            $class = ucfirst($entity) . "Repository";
            $filename = "model/" . $class . ".php";
            if (file_exists($filename)) {
                include_once($filename);
                $this->repos[$entity] = new $class($this->app->getDb());
                return $this->repos[$entity];
            }
        }
        return null;
    }
}
