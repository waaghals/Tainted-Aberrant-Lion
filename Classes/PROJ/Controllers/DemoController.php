<?php

namespace PROJ\Controller;

class DemoController extends BaseController{

    private static $instance;

    /**
     * @return \PROJ\Controller\DemoController
     */
    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function DoDemoAction() {
        $r = null;

        /** URL parameters opvragen:       * */
        /** print_r($this->parameters)      * */
        /** Nieuwe entry maken in de database * */
        //Entitie Manager ophalen
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();

        //Entitie aanmaken & Vullen
        $e = new \PROJ\Entities\VoorbeeldEntitie1();
        $e->setName("TEST");
        $e->setINTwaarde(2);

        //2e entitie aanmaken voor test One to One relation
        $e2 = new \PROJ\Entities\VoorbeeldEntitie2();
        $e2->setName("TEST2");
        $e2->setINTwaarde(99);

        //Eerst de 2e entitie persisten
        $em->persist($e2);

        //Entitie 2 aan 1 toevoegen
        $e->setOneToOneRelation($e2);
        $em->persist($e);

        //Opslaan naar de database
        $em->flush();




        /** Opvragen van alle entities uit een tabel * */
        $a = $em->getRepository('PROJ\Entities\VoorbeeldEntitie1')->findAll();

        //Hier kun je dan gewoon doorheen loopen
        $r .= '<br><b>FindAll:</b><br>';
        foreach ($a as $entity) {
            $r .= $entity->getName() . ' - ' . $entity->getINTwaarde() . '<br>';
        }



        /** Opvragen van specefieke entries uit een tabel (geen ingewikkelde query's) * */
        $a = $em->getRepository('PROJ\Entities\VoorbeeldEntitie1')->findBy(array('name' => 'TEST', 'id' => 1));

        //Hier kun je dan gewoon doorheen loopen
        $r .= '<br><b>FindBy:</b><br>';
        foreach ($a as $entity) {
            $r .= $entity->getName() . ' - ' . $entity->getINTwaarde() . '<br>';
        }



        /** Doctrine query opbouwen * */
        //Eerst een query Builder maken
        $qb = $em->createQueryBuilder();
        $qb->select('e1')
                ->from('\PROJ\Entities\VoorbeeldEntitie1', 'e1')
                ->where($qb->expr()->eq('e1.name', $qb->expr()->literal('TEST')))   //$qb->expr()->literal() geeft aan dat het om een letterlijke string gaat
                ->orderBy('e1.name', 'ASC')
                ->setMaxResults(4);

        //Bovenstaande is gelijk aan:
        //SELECT e1.*
        //FROM \PROJ\Entities\Voorbeeldentitie1 AS e1
        //WHERE e1.name = 'TEST'
        //ORDER BY e1.name ASC
        //Results ophalen
        $res = $qb->getQuery()->getResult();

        //Hier kun je dan gewoon doorheen loopen
        $r .= '<br><b>Query Builder:</b><br>';
        foreach ($res as $entity) {
            $r .= $entity->getName() . ' - ' . $entity->getINTwaarde() . '<br>';
        }



        /** Entitie relatie selecteren * */
        $r .= '<br><b>Relatie naam:</b><br>';
        $r .= $e->getOneToOneRelation()->getName();


        /** Entitie Updaten * */
        $temp = $e->getOneToOneRelation()->setName("TEST 123");
        $em->persist($temp);
        $em->flush();


        /** Entitie uit de database removen * */
        //Eerst zorg je dat je op een of andere manier een entitie geselect hebt.
        //Ik pak hier de nieuw aangemaakte entitie hierboven.
        //$em->remove($e);
        //$em->flush();

        echo $r;
    }

}

?>