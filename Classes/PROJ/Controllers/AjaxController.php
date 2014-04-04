<?php

namespace PROJ\Controllers;

use PROJ\Exceptions\ServerException;
use PROJ\Helper\DoctrineHelper;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class AjaxController extends BaseController {

    public function allMarkersAction() {
        $mc = new \PROJ\Classes\MarkerCollection();

        //Alle Instellingen ophalen
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $reviews = $em->getRepository('\PROJ\Entities\Institute')->findAll();

        foreach ($reviews as $rev) {
            //Gemiddelde score berekenen
            $qb = $em->createQueryBuilder();
            $qb->select('avg(review.rating) as AVGSCORE, count(review.id) as AANTALREVIEWS')
                    ->from('\PROJ\Entities\Institute', 'institute')
                    ->leftJoin('institute.projects', 'project')
                    ->leftJoin('project.review', 'review')
                    ->where($qb->expr()->eq('institute.id', $qb->expr()->literal($rev->getId())));
            $avg = $qb->getQuery()->getResult();



            $demoMarker = new \PROJ\Classes\Marker();
            $demoMarker->setLat($rev->getLat());
            $demoMarker->setLong($rev->getLong());
            if ($rev->getType() == "Minor")
                $demoMarker->setColor('58D2FF');
            elseif ($rev->getType() == "Both")
                $demoMarker->setColor('58E579');

            $markerHtml = "<div style='width:400px; height:200px;'><h4>" . $rev->getNaam() . "</h4><br>"
                    . "Gemiddelde Score: " . number_format($avg[0]['AVGSCORE'], 1);
            if ($avg[0]['AANTALREVIEWS'] == 0)
                $markerHtml .= "<br><br>Er zijn nog geen reviews geschreven voor " . $rev->getNaam() . "</div>";
            else
                $markerHtml .= "<br><br><a href='#' class='AllReviews' instantie='" . $rev->getId() . "'>Alle (" . $avg[0]['AANTALREVIEWS'] . ") Reviews Bekijken</a></div>";

            $demoMarker->setHtml($markerHtml);
            $demoMarker->setTitle($rev->getName());

            $mc->addMarkerLocation($rev->getName(), $demoMarker);
        }
        echo $mc->generateMarkerJSON();
    }

    public function allLocationsAction() {
        $em = DoctrineHelper::instance()->getEntityManager();

        $dql = "SELECT i, p, r, s FROM \PROJ\Entities\Institute i LEFT JOIN i.projects p LEFT JOIN p.review r LEFT JOIN p.student s";
        $q = $em->createQuery($dql);

        $res = $q->getArrayResult();

        echo json_encode($res);
    }

    public function locationReviewAction($lid = 1) {
        $lid = intval($lid);

        if (!is_int($lid)) {
            $msg = "Not a valid location id.";
            throw new ServerException($msg, ServerException::SERVER_ERROR);
        }

        $em = DoctrineHelper::instance()->getEntityManager();
        $instances = $em->getRepository('\PROJ\Entities\Institute')->find($lid);

        echo json_encode($instances);
    }

    public function getProjectInfoAction() {
        $returnArray;
        $tag = filter_var($_POST['tag'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $em = DoctrineHelper::instance()->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select(array('student.firstname as studentname', 'student.surname as studentsurname', 'student.email', 'review.text', 'institute.name as institutename', 'review.rating', 'review.id as revid', 'institute.id as instituteid', 'institute.lat', 'institute.lng'))
                ->from('\PROJ\Entities\Review', 'review')->leftJoin('review.project', 'project')->leftJoin('project.institute', 'institute')->leftJoin('project.student', 'student')
                ->where($qb->expr()->like("review.text", $qb->expr()->literal("%" . $tag . "%")))
                ->orWhere($qb->expr()->like("student.firstname", $qb->expr()->literal("%" . $tag . "%")))
                ->orWhere($qb->expr()->like("student.surname", $qb->expr()->literal("%" . $tag . "%")));
        
        $result = $qb->getQuery()->getResult();
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]["text"] = substr($result[$i]["text"], 0, 50);
            $result[$i]["matchedOn"] = "review";
        }
        $returnArray = $result;
        
        
        $qb = $em->createQueryBuilder();
        $qb->select(array('student.firstname as studentname', 'student.surname as studentsurname', 'student.email', 'review.text', 'institute.name as institutename', 'institute.place as instituteplace', 'institute.id as instituteid', 'review.rating', 'institute.lat', 'institute.lng'))
                ->from('\PROJ\Entities\Review', 'review')->leftJoin('review.project', 'project')->leftJoin('project.institute', 'institute')->leftJoin('project.student', 'student')
                ->where($qb->expr()->like("institute.name", $qb->expr()->literal("%" . $tag . "%")));
        
        $result = $qb->getQuery()->getResult();
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]["text"] = substr($result[$i]["text"], 0, 50);
            $result[$i]["matchedOn"] = "instname";
        }
        $returnArray = array_merge($returnArray,$result);
        
        //Max 8 results
        array_splice($returnArray, 8);
        
        
        echo json_encode($returnArray);
    }
    
     public function createLocationAction() {
        if (empty($_POST['type']) || empty($_POST['name']) || empty($_POST['country'])
                || empty($_POST['city']) || empty($_POST['street']) || empty($_POST['housenumber']) 
                || empty($_POST['postalcode']) || empty($_POST['email'])) {
            echo "Not everything is filled in";
            return;
        }
        foreach($_POST as $input){
            if($input == $_POST['housenumber'])
                break;
            
            if(strlen($input) > 254) {
                echo "Some fieldes are too long.";
                return;
            }
            if(!preg_match('/^[A-Za-z0-9. -_]{1,31}$/', $input)) {
                echo "No special characters allowed";
                return;
            }
        }
        if(!(filter_var($_POST['housenumber'], FILTER_VALIDATE_INT))) {
            echo "Streetnumber is not a number";
            return;
        }
        
        if($_POST['type'] != "education" && $_POST['type'] != "business")
            die();
        
        $em = DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();
        if($ac->isLoggedIn()) {
            
            $country = $em->getRepository('\PROJ\Entities\Country')->find($_POST['country']);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_POST['street'].' '.$_POST['housenumber'].', '.$_POST['city'].', '.$country->getName()).'&sensor=false');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = json_decode(curl_exec($ch), true);
            
            if ($response['status'] != 'OK') {
                echo("Could not Geocode. Location was not created.");
                return;
            }
            
            $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID']);
            $locatie = new \PROJ\Entities\Institute();
            $locatie->setCreator($user->getStudent());
            $locatie->setLat($response["results"][0]["geometry"]["location"]['lat']);
            $locatie->setLng($response["results"][0]["geometry"]["location"]['lng']);
            $place = \PROJ\Helper\XssHelper::sanitizeInput($_POST['city']);
            foreach($response["results"][0]["address_components"] as $comp) {
                if(in_array("locality", $comp["types"])) {
                    $place = $comp["long_name"];
                }
            }
            $locatie->setPlace($place);
            $locatie->setType($_POST['type']);
            $locatie->setName(\PROJ\Helper\XssHelper::sanitizeInput($_POST['name']));
            
            $em->persist($locatie);
            $em->flush();
        }
        
        echo 'succes';
     }

}
