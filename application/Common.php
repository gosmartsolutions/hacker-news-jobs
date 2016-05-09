<?php
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE | E_STRICT); // Warns on good coding standards
ini_set("display_errors", "1");
require 'Config.php';
require 'HelperFunctions.php';

//Autoloading stuff which autoloads class files based on class name called
//This avoids having to add includes for every class file
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$db = Database::getInstance();




