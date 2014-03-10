<?php

namespace PROJ\Controller;

class DemoController {

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

    public function DoDemo() {
        $r = null;

        /** Request url parameters:       * */
        /** print_r($this->parameters)      * */
        /** create new entry in database * */
        //Entitie Manager ophalen
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();

        // Create entity & fill it
        $e = new \PROJ\Entities\VoorbeeldEntitie1();
        $e->setName("TEST");
        $e->setINTparameter(2);

        //create 2nd entity to test One to One relation
        $e2 = new \PROJ\Entities\VoorbeeldEntitie2();
        $e2->setName("TEST2");
        $e2->setINTparameter(99);

        //first the first one persist
        $em->persist($e2);

        //Add entity 2 to 1 
        $e->setOneToOneRelation($e2);
        $em->persist($e);

        //Save to database
        $em->flush();




        /** Request all entity's from table * */
        $a = $em->getRepository('PROJ\Entities\VoorbeeldEntitie1')->findAll();

        //Can loop trough here
        $r .= '<br><b>FindAll:</b><br>';
        foreach ($a as $entity) {
            $r .= $entity->getName() . ' - ' . $entity->getINTwaarde() . '<br>';
        }



        /** request specific entry's from a table(no hard query's) * */
        $a = $em->getRepository('PROJ\Entities\VoorbeeldEntitie1')->findBy(array('name' => 'TEST', 'id' => 1));

        //just a loop
        $r .= '<br><b>FindBy:</b><br>';
        foreach ($a as $entity) {
            $r .= $entity->getName() . ' - ' . $entity->getINTparameter() . '<br>';
        }



        /** Doctrine query build-up * */
        //create a querry builder first
        $qb = $em->createQueryBuilder();
        $qb->select('e1')
                ->from('\PROJ\Entities\VoorbeeldEntitie1', 'e1')
                ->where($qb->expr()->eq('e1.name', $qb->expr()->literal('TEST')))   //$qb->expr()->literal() geeft aan dat het om een letterlijke string gaat
                ->orderBy('e1.name', 'ASC')
                ->setMaxResults(4);

        //the above is the same as:
        //SELECT e1.*
        //FROM \PROJ\Entities\Voorbeeldentitie1 AS e1
        //WHERE e1.name = 'TEST'
        //ORDER BY e1.name ASC
        //get results
        $res = $qb->getQuery()->getResult();

        //|Just a loop 
        $r .= '<br><b>Query Builder:</b><br>';
        foreach ($res as $entity) {
            $r .= $entity->getName() . ' - ' . $entity->getINTparameter() . '<br>';
        }



        /** Select entity relation * */
        $r .= '<br><b>Relation name:</b><br>';
        $r .= $e->getOneToOneRelation()->getName();


        /** Update entity * */
        $temp = $e->getOneToOneRelation()->setName("TEST 123");
        $em->persist($temp);
        $em->flush();


        /** Remote entity from database * */
        //Eerst zorg je dat je op een of andere manier een entitie geselect hebt.
        //Ik pak hier de nieuw aangemaakte entitie hierboven.
        //$em->remove($e);
        //$em->flush();

        return $r;
    }

}

?>