<?php
//start session
session_start();

//Init Doctrine
use Doctrine\Common\ClassLoader;
use PROJ\Helper\HeaderHelper;
use PROJ\Tools\Request;
use PROJ\Tools\Router;
use PROJ\Exceptions\ServerException;

require __DIR__ . '/Doctrine/Common/ClassLoader.php';

$classLoader = new ClassLoader('Doctrine', __DIR__ . '/');
$classLoader->register();
$classLoader = new ClassLoader('Symfony', __DIR__ . '/Doctrine');
$classLoader->register();
$classLoader = new ClassLoader('PROJ', __DIR__ . '/Classes');
$classLoader->register();

/**
 * @def (string) DS - Directory separator.
 */
define("DS", "/", true);

/**
 * @def (resource) BASE_PATH - get a base path.
 */
define('BASE_PATH', realpath(dirname(__FILE__)) . DS, true);


//POST & GET data opschonen
/* foreach ($_POST as $key => $p)
  $_POST[$key] = trim(strip_tags(htmlspecialchars($p)));
  foreach ($_GET as $key => $p)
  $_GET[$key] = trim(strip_tags(htmlspecialchars($p)));

  //Parameters ophalen
  $requestURL = substr($_GET['r'], 0, -1);
  $URLparameters = explode('/', $requestURL);

  //Pagina laden & Checken of deze class weergegeven mag worden
  //Checken voor ajax


  if($URLparameters[0] == "ajax")
  $ref = new ReflectionClass('PROJ\Pages\Ajax\\' . $URLparameters[1]);
  else
  $ref = new ReflectionClass('PROJ\Pages\\' . $URLparameters[0]);
  if ($ref->getParentClass() != null) {
  if ($ref->getParentClass()->getName() == 'PROJ\Pages\MainPage') {
  if($URLparameters[0] == "ajax")
  $classname = 'PROJ\Pages\Ajax\\' . $URLparameters[1];
  else
  $classname = 'PROJ\Pages\\' . $URLparameters[0];

  //Class maken & Parameters meegeven
  $class = new $classname();
  $class->setURLParameters($URLparameters);
  echo $class->show();
  } else {
  header("HTTP/1.0 404 Not Found");
  }
  } else {
  header("HTTP/1.0 404 Not Found");
  }
 */

//Perform the router magic, call the correct controller and action
//based on the uri
try {
    $req = new Request();
    Router::match($req);
} catch (ServerException $e) {
    echo sprintf("<h1>Error: %s</h1>", HeaderHelper::getStatus($e->getCode()));
    echo sprintf("<p>Message: %s</p>", $e->getMessage());
    HeaderHelper::show($e->getCode());
}
