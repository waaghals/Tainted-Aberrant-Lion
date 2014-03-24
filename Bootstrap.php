<?php

define("DS", "/", true);
define('BASE_PATH', realpath(dirname(__FILE__)) . DS, true);

//Init Doctrine
use Doctrine\Common\ClassLoader;

require BASE_PATH . '/Doctrine/Common/ClassLoader.php';

$classLoader = new ClassLoader('Doctrine', BASE_PATH . '/');
$classLoader->register();
$classLoader = new ClassLoader('Symfony', BASE_PATH . '/Doctrine');
$classLoader->register();
$classLoader = new ClassLoader('PROJ', BASE_PATH . '/Classes');
$classLoader->register();
