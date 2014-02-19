<form method="post" action="console.php">
    <input type="text" name="command" style="width: 400px;">
    <input type="submit" value="Submit">
</form>
<?php
error_reporting(-1);
ini_set('display_errors', '1');
set_time_limit(0);

require __DIR__ . '/Doctrine/Common/ClassLoader.php';

use Doctrine\Common\ClassLoader;

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine', __DIR__);
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', __DIR__ . '/Doctrine');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader(null, __DIR__ . '/Classes');
$classLoader->register();

if (@$_POST['command']) {
    echo "command executed:<br/>";
    $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();

    $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
    ));

    $command = $_POST["command"];
    $commandarray = array_merge(array('doctrine'), explode(" ", $command));

    \PROJ\Tools\CodeConsoleRunner::run($helperSet, new \Symfony\Component\Console\Input\ArgvInput($commandarray), new \Symfony\Component\Console\Output\StreamOutput(fopen('php://output', 'w'))
    );
}
?>