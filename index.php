<?php

//Init Doctrine
use Doctrine\Common\ClassLoader;

require __DIR__ . '/Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine', __DIR__ . '/');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', __DIR__ . '/Doctrine');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader(null, __DIR__ . '/Classes');
$classLoader->register();

//POST & GET data opschonen
foreach ($_POST as $key => $p)
    $_POST[$key] = trim(strip_tags(htmlspecialchars($p)));
foreach ($_GET as $key => $p)
    $_GET[$key] = trim(strip_tags(htmlspecialchars($p)));

//Parameters ophalen
$requestURL = substr($_GET['r'], 0, -1);
$URLparameters = explode('/', $requestURL);

//Pagina laden & Checken of deze class weergegeven mag worden
$ref = new ReflectionClass('PROJ\Pages\\' . $URLparameters[0]);
if ($ref->getParentClass() != null) {
    if ($ref->getParentClass()->getName() == 'PROJ\Pages\MainPage') {
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
?>
<?php
use GoogleMap;

getHtml();
?>
