<?php

/**
 * User is a BO to handle users
 *
 * @author humanbooster
 */
class User extends Entity {
    /**
     * Id of the user
     * 
     * @var int  
     */
    public $id;
    
    /**
     * Login / username
     * 
     * @var string  
     */
    public $login;
    
    /**
     * Email address
     * 
     * @var string
     */
    public $email;
    
    /**
     * Password (plain now)
     * 
     * @var string
     * @todo use sha1
     */
    public $password;
    
    /**
     * Full name
     * 
     * @var string
     */
    public $name;
    
    /**
     * Date of birth
     * 
     * @var \Date 
     */
    public $birthDate;
    
    /**
     * Register datetime
     * 
     * @var \DateTime
     */
    public $registerDate;
    
    /**
     * Last login datetime
     * 
     * @var \DateTime
     */
    public $lastLoginDate;
}
