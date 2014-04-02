<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestdataControllerr
 *
 * @author Dennis
 */

use PROJ\Exceptions\ServerException;
namespace PROJ\Controllers;

class TestdataController extends BaseController

{
  
    public function createAction(){
         $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $instituteE = new \PROJ\Entities\Institute(); 
        $instituteE->setName("Avans Hogeschool");
        $instituteE->setType("education");
        $instituteE->setPlace("`s-Hertogenbosch");
        $instituteE->setLat(51.688946);
        $instituteE->setLong(5.287256);
        $em->persist($instituteE);
        $em->flush();
        echo "Educational Institute test data has been added to the database successfully <br />";
        $instituteB = new \PROJ\Entities\Institute(); 
        $instituteB->setName("McDonald's");
        $instituteB->setType("business");
        $instituteB->setPlace("Arnhem");
        $instituteB->setLat(51.9635996);
        $instituteB->setLong(5.8930421);
        $em->persist($instituteB);
        $em->flush();
        echo "Business Institute test data has been added to the database successfully <br />";
        
        $accountJ = new \PROJ\Entities\Account();
        $salt = "HGJDGFSJHDFJHSDf";
        $hash = hash('sha512', "qwerty" . $salt);
        $accountJ->setPassword($hash);
        $accountJ->setUsername("kjansen");
        $accountJ->setSalt($salt);
        $em->persist($accountJ);
        $em->flush();
        echo "New account Jansen test data has been added to the database successfully<br />";
        
        $accountB = new \PROJ\Entities\Account();
        $salt = "E*(%&YUIERHDGFER";
        $hash = hash('sha512', "password" . $salt);
        $accountB->setPassword($hash);
        $accountB->setUsername("hbakker");
        $accountB->setSalt($salt);
        $em->persist($accountB);
        $em->flush();
        echo "New account Bakker test data has been added to the database successfully<br />";
        
        $studentB = new \PROJ\Entities\Student(); 
        $studentB->setFirstname("harry");
        $studentB->setSurname("bakker");
        $studentB->setCity("utrecht");
        $studentB->setAccount($accountB);
        $studentB->setStreet("teststraat");
        $studentB->setHousenumber(15);
        $studentB->setEmail("h.bakker@student.avans.nl");
        $studentB->setZipcode("3500AB");
        $em->persist($studentB);
        $em->flush();
        echo "New student with a business institute test data has been added to the database successfully <br />";
        
        $studentE = new \PROJ\Entities\Student(); 
        $studentE->setFirstname("Kees");
        $studentE->setSurname("Jansen");
        $studentE->setCity("eindhoven");
        $studentE->setAccount($accountJ);
        $studentE->setStreet("teststraat");
        $studentE->setHousenumber(15);
        $studentE->setEmail("k.jansen@student.avans.nl");
        $studentE->setZipcode("3500AB");
        $em->persist($studentE);
        $em->flush();
        echo "New student with a educational institute test data has been added to the database successfully <br />";
        
        $projectB = new \PROJ\Entities\Project(); 
        $projectB->setInstitute($instituteB);
        $projectB->setStartdate($startDate = new \DateTime('03/17/2014'));
        $projectB->setendDate($endDate = new \DateTime('05/17/2014'));
        $projectB->setStudent($studentB);
        $projectB->setType("internship");
        $em->persist($projectB);
        $em->flush();
        echo "New project with a business institute test data has been added to the database succesfully <br />";
        
        $projectE = new \PROJ\Entities\Project(); 
        $projectE->setInstitute($instituteE);
        $projectE->setStartdate($startDate = new \DateTime('02/04/2014'));
        $projectE->setendDate($endDate = new \DateTime('06/20/2014'));
        $projectE->setStudent($studentE);
        $projectE->setType("minor");
        $em->persist($projectE);
        $em->flush();
        echo "New project with a educational institute test data has been added to the database succesfully <br />";
        
        $reviewB = new \PROJ\Entities\Review(); 
        $reviewB->setProject($projectB);
        $reviewB->setRating(5);
        $reviewB->setText("Good things happend here B");
        $em->persist($reviewB);
        $em->flush();
        echo "New review with a business institute test data has been added to the database successfully<br />";
        
        $reviewE = new \PROJ\Entities\Review(); 
        $reviewE->setProject($projectE);
        $reviewE->setRating(4);
        $reviewE->setText("Good things happend here");
        $em->persist($reviewE);
        $em->flush();
        echo "New review with a educational institute test data has been added to the database successfully<br />";
        
        $registrationCode = new \PROJ\Entities\RegistrationCode();
        $registrationCode->setCode("1234567890");
        $registrationCode->setEmail("pat@example.com");
        $em->persist($registrationCode);
        $em->flush();
        echo "New registrationcode has been added to the database succesfully <br />";
    }
}

?>

