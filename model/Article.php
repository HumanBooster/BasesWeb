<?php

/**
 * Article is a BO to handle articles
 *
 * @author humanbooster
 */
class Article extends Entity {
    /**
     * Id of the article
     * 
     * @var int  
     */
    public $id;
    
    /**
     * Title of the article
     * 
     * @var string  
     */
    public $title;
    
    /**
     * Content of the article
     * 
     * @var string
     */
    public $content;
}
