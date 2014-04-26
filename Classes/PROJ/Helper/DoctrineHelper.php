<?php

namespace PROJ\Helper;

use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration;

class DoctrineHelper
{

    private static $instance;

    /**
     *
     * @return \PROJ\Helper\DoctrineHelper instance
     */
    public static function instance()
    {
        if (self::$instance == null)
            self::$instance = new self();

        return self::$instance;
    }

    private $EntityManager;

    private function __construct()
    {
        $this->initialize();
    }

    private function initialize()
    {
        $applicationMode = "development";

        if ($applicationMode == "development") {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcCache;
        }

        $standard_namespace = 'PROJ';
        $config = new Configuration;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(array(
            'Classes/' . $standard_namespace . '/Entities'
        ));
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir('Classes/' . $standard_namespace . '/Proxies');
        $config->setProxyNamespace($standard_namespace . '\Proxies');

        if ($applicationMode == "development") {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        $connectionOptions = array(
            'dbname' => 'Agile', //Databasenaam
            'user' => 'agile', //Username
            'password' => 'tpY8^jEX171/WL1', //Password
            'host' => 'localhost',
            'driver' => 'pdo_mysql'
        );

        $em = EntityManager::create($connectionOptions, $config);

        //Fix, Allowes doctrine to use enum's
        $platform = $em->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        //Type registration
        \Doctrine\DBAL\Types\Type::addType('projectstate', 'PROJ\DBAL\ApprovalStateType');

        $conn = $em->getConnection();

        $this->EntityManager = $em;
    }

    /**
     *
     * @return \Doctrine\ORM\EntityManager $entityManager
     */
    public function getEntityManager()
    {
        return $this->EntityManager;
    }

}

?>