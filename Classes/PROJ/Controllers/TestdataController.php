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
  
    public function createTestdataAction(){
         $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $instituteE = new \PROJ\Entities\Institute(); 
        $instituteE->setName("Avans");
        $instituteE->setType("education");
        $instituteE->setLat(51);
        $instituteE->setLong(5);
        $em->persist($instituteE);
        $em->flush();
        echo "Educational Institute test data has been added to the database succesfully <br />";
        $instituteB = new \PROJ\Entities\Institute(); 
        $instituteB->setName("Gateway");
        $instituteB->setType("business");
        $instituteB->setLat(50);
        $instituteB->setLong(6);
        $em->persist($instituteB);
        $em->flush();
        echo "Business Institute test data has been added to the database succesfully <br />";
        $student = new \PROJ\Entities\Student(); 
        $student->setFirstname("harry");
        $student->setSurname("bakker");
        $student->setCity("utrecht");
        $student->setAccount(null);
        $student->setStreet("teststraat");
        $student->setHousenumber(15);
        $student->setEmail("faggot@fag.nl");
        $student->setZipcode("3500AB");
        $em->persist($student);
        $em->flush();
        echo "New student test data has been added to the database succesfully <br />";
        $project = new \PROJ\Entities\Project(); 
        $project->setInstitute(null);
        $project->setStartdate("2014-03-17");
        $project->setendDate("2014-05-17");
        $project->setStudent(null);
        $project->setType("internship");
        $em->persist($project);
        $em->flush();
        echo "New project test data has been added to the database succesfully <br />";
        $review = new \PROJ\Entities\Review(); 
        $review->setProject(null);
        $review->setRating(11);
        $review->setText("Good things happend here");
        $em->persist($review);
        $em->flush();
        echo "New review test data has been added to the database succesfully<br />";
    }
    
    // each testdata for each table. 
    public function createEduInstiTDAction(){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $institute = new \PROJ\Entities\Institute(); 
        $institute->setName("Avans");
        $institute->setType("education");
        $institute->setLat(51);
        $institute->setLong(5);
        $em->persist($institute);
        $em->flush();
        echo "Educational Institute test data has been added to the database succesfully \n";
        
    }
    public function createBusinstiTDAction(){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $institute = new \PROJ\Entities\Institute(); 
        $institute->setName("Gateway");
        $institute->setType("business");
        $institute->setLat(50);
        $institute->setLong(6);
        $em->persist($institute);
        $em->flush();
    echo "Business Institute test data has been added to the database succesfully \n";

    }

        public function createStudentAction(){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $student = new \PROJ\Entities\Student(); 
        $student->setFirstname("harry");
        $student->setSurname("bakker");
        $student->setCity("utrecht");
        $student->setAccount(null);
        $student->setStreet("teststraat");
        $student->setHousenumber(15);
        $student->setEmail("faggot@fag.nl");
        $student->setZipcode("3500AB");
        $em->persist($student);
        $em->flush();
        echo "New student test data has been added to the database succesfully";

    }
    public function createProjectAction(){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $project = new \PROJ\Entities\Project(); 
        $project->setInstitute(1);
        $project->setStartdate("2014-03-17");
        $project->setendDate("2014-05-17");
        $project->setStudent(1);
        $em->persist($project);
        $em->flush();
        echo "New project test data has been added to the database succesfully";

    }
    public function createReview(){
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $review = new \PROJ\Entities\Review(); 
        $review->setProject(null);
        $review->setRating(11);
        $review->setText("Good things happend here");
        $em->persist($review);
        $em->flush();
        echo "New review test data has been added to the database succesfully<br />";

    }
}
?>

