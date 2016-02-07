<?php
// Start the session
session_start();
// Set timezone
date_default_timezone_set("America/Chicago");
// Prevent session cookies
ini_set("session.use_cookies", 0);

// Enable Composer autoloader
/** @var \Composer\Autoload\ClassLoader $autoloader */
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__));
$autoloader = require_once("../vendor/autoload.php");
// Register test classes
$autoloader->addPsr4("App\Tests\\", __DIR__);
