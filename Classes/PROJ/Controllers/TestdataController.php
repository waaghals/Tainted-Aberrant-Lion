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

namespace PROJ\Controllers;

use PROJ\Exceptions\ServerException;
use \PROJ\Entities\Institute;
use \PROJ\Entities\Account;
use \PROJ\Entities\Student;
use \PROJ\Entities\Project;
use \PROJ\Entities\Review;

class TestdataController extends BaseController {

    private function emptyTables($em) {
        $helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
            'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
        ));
        $command1 = "orm:schema-tool:drop --force";
        $command2 = "orm:schema-tool:update --force";
        $commandarray1 = array_merge(array('doctrine'), explode(" ", $command1));
        $commandarray2 = array_merge(array('doctrine'), explode(" ", $command2));
        \PROJ\Tools\CodeConsoleRunner::run($helperSet, new \Symfony\Component\Console\Input\ArgvInput($commandarray1), new \Symfony\Component\Console\Output\StreamOutput(fopen('php://output', 'w')));
        echo "<br />";
        \PROJ\Tools\CodeConsoleRunner::run($helperSet, new \Symfony\Component\Console\Input\ArgvInput($commandarray2), new \Symfony\Component\Console\Output\StreamOutput(fopen('php://output', 'w')));
        echo "<br /><br />";
    }

    private function createInstitute($em, $name, $type, $place, $lat, $long) {
        $institute = new Institute();
        $institute->setName($name);
        $institute->setType($type);
        $institute->setPlace($place);
        $institute->setLat($lat);
        $institute->setLng($long);
        $em->persist($institute);
        $em->flush();
        echo "Institute with the following data has been succesfully added to the database:"
        . "<br />Name: " . $name
        . "<br />Type: " . $type
        . "<br />Place: " . $place
        . "<br />Latitude: " . $lat
        . "<br />Longtitude: " . $long
        . "<br /><br />";
        return $institute;
    }

    private function createUser($em, $username, $password, $salt) {
        $account = new Account();
        $account->setUsername($username);
        $hash = hash('sha512', $password . $salt);
        $account->setPassword($hash);
        $account->setSalt($salt);
        $em->persist($account);
        $em->flush();
        echo "New account with the following data has been succesfully added to the database:"
        . "<br />Username: " . $username
        . "<br />Password: " . $password
        . "<br />Salt: " . $salt
        . "<br /><br />";
        return $account;
    }

    private function createStudent($em, $fName, $sName, $street, $housenr, $zipcode, $city, $account, $email) {
        $student = new Student();
        $student->setFirstname($fName);
        $student->setSurname($sName);
        $student->setStreet($street);
        $student->setHousenumber($housenr);
        $student->setZipcode($zipcode);
        $student->setCity($city);
        $student->setAccount($account);
        $student->setEmail($email);
        $em->persist($student);
        $em->flush();
        echo "New student with the following data has been succesfully added to the database:"
        . "<br />Firstname: " . $fName
        . "<br />Surname: " . $sName
        . "<br />Street: " . $street
        . "<br />Housenumber: " . $housenr
        . "<br />Zipcode: " . $zipcode
        . "<br />City: " . $city
        . "<br />Account: " . $account->getUsername()
        . "<br />Email: " . $email
        . "<br /><br />";
        return $student;
    }

    private function createProject($em, $student, $institute, $type, $startDate, $endDate) {
        $project = new Project();
        $project->setStudent($student);
        $project->setInstitute($institute);
        $project->setType($type);
        $project->setStartdate($startDate);
        $project->setendDate($endDate);
        $em->persist($project);
        $em->flush();
        echo "New project with the following data has been succesfully added to the database:"
        . "<br />Student: " . $student->getFirstname() . " " . $student->getSurname()
        . "<br />Institute: " . $institute->getName()       
        . "<br />Type: " . $type
        . "<br /><br />";
        return $project;
    }

    private function createReview($em, $project, $assignRate, $accoRate, $guidRate, $text) {
        $review = new Review();
        $review->setProject($project);
        $review->setAssignmentRating($assignRate);
        $review->setAccommodationRating($accoRate);
        $review->setGuidanceRating($guidRate);
        $review->setText($text);
        $em->persist($review);
        $em->flush();
        echo "New review with the following data has been succesfully added to the database:"
        . "<br />Institute: " . $project->getInstitute()->getName()
        . "<br />Assignment rating: " . $assignRate
        . "<br />Accomodation rating: " . $accoRate
        . "<br />Guidance rating: " . $guidRate
        . "<br />Text: " . $text
        . "<br /><br />";
    }

    public function IndexAction() {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();

        $this->emptyTables($em);

        $avans = $this->createInstitute($em, "Avans Hogeschool", "education", "`s-Hertogenbosch", 51.688946, 5.287256);
        $mac = $this->createInstitute($em, "McDonald's", "business", "Arnhem", 51.9635996, 5.8930421);

        $kjansen = $this->createUser($em, "kjansen", "qwerty", "HGJDGFSJHDFJHSDf");
        $hbakker = $this->createUser($em, "hbakker", "password", "E*(%&YUIERHDGFER");

        $kees = $this->createStudent($em, "Kees", "Jansen", "Jansenlaan", 15, "1234AB", "eindhoven", $kjansen, "k.jansen@student.avans.nl");
        $harry = $this->createStudent($em, "Harry", "Bakker", "Bakkersweg", 15, "5678CD", "utrecht", $hbakker, "h.bakker@student.avans.nl");

        $projectX = $this->createProject($em, $kees, $avans, "internship", new \DateTime('03/17/2014'), new \DateTime('05/17/2014'));
        $projectZ = $this->createProject($em, $harry, $mac, "minor", new \DateTime('02/04/2014'), new \DateTime('06/20/2014'));

        $this->createReview($em, $projectX, 5, 3, 4, "Many fun activities to do here!");
        $this->createReview($em, $projectZ, 4, 4, 1, "Just do your job and they're happy.");
    }

}
?>

