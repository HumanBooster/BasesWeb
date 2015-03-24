<?php
/**
 * All static includes should go here
 */

session_start();

require("includes/db_connect.php");
require("includes/functions.php");
require("view/View.php");
require("model/Entity.php");
require("model/Repository.php");
require("controller/Controller.php");
require("includes/Application.php");