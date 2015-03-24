<?php

/**
 * Controller is the top level class for every controller
 *
 * @author humanbooster
 */
class Controller {

    /**
     * Stores the application (Dependency Injection pattern)
     * 
     * @var Application 
     */
    protected $app;

    /**
     * Constructor of the class ArticleController
     * 
     * @param Application $app
     */
    public function __construct($app) {
        $this->app = $app;
    }
    
    /**
     * Returns the repository of the required entity
     * 
     * @param string $entity
     * @return Repository (currently ArticleRepository only)
     */
    protected function getRepository($entity) {
        return $this->app->getService("repository")->get($entity);
    }
}
