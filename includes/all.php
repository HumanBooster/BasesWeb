<?php

session_start();

require("includes/db_connect.php");
require("includes/functions.php");
require("view/View.php");
require("model/Article.php");
require("model/ArticleRepository.php");
require("controller/ArticleController.php");