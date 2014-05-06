<?php

/**
 * Geen ServerErrors in dit document; Dan komt de AJAX call niet meer terug.
 */

namespace PROJ\Controllers;

use PROJ\Exceptions\ServerException;
use PROJ\Helper\DoctrineHelper;
use PROJ\DBAL\ApprovalStateType as Status;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class AjaxController extends BaseController
{

    public function allMarkersAction()
    {
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
            if ($rev->getType() == "Minor") {
                $demoMarker->setColor('58D2FF');
            } elseif ($rev->getType() == "Both") {
                $demoMarker->setColor('58E579');
            }

            $markerHtml = "<div style='width:400px; height:200px;'><h4>" . $rev->getNaam() . "</h4><br>"
                    . "Gemiddelde Score: " . number_format($avg[0]['AVGSCORE'], 1);
            if ($avg[0]['AANTALREVIEWS'] == 0) {
                $markerHtml .= "<br><br>Er zijn nog geen reviews geschreven voor " . $rev->getNaam() . "</div>";
            } else {
                $markerHtml .= "<br><br><a href='#' class='AllReviews' instantie='" . $rev->getId() . "'>Alle (" . $avg[0]['AANTALREVIEWS'] . ") Reviews Bekijken</a></div>";
            }

            $demoMarker->setHtml($markerHtml);
            $demoMarker->setTitle($rev->getName());

            $mc->addMarkerLocation($rev->getName(), $demoMarker);
        }
        echo $mc->generateMarkerJSON();
    }

    public function allLocationsAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();

        $qb = $em->createQueryBuilder();
        $res = $qb->select(array('i', 'p', 'r', 's', 'c'))
                ->from('\PROJ\Entities\Institute', 'i')
                ->leftJoin('i.projects', 'p')
                ->leftJoin('p.review', 'r')
                ->leftJoin('p.student', 's')
                ->leftJoin('i.country', 'c')
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        echo json_encode($res);
    }

    public function locationReviewAction($lid = 1)
    {
        $lid = intval($lid);

        if (!is_int($lid)) {
            $msg = "Not a valid location id.";
            throw new ServerException($msg, ServerException::SERVER_ERROR);
        }

        $em = DoctrineHelper::instance()->getEntityManager();
        $instances = $em->getRepository('\PROJ\Entities\Institute')->find($lid);

        echo json_encode($instances);
    }

    public function getProjectInfoAction()
    {
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
        $returnArray = array_merge($returnArray, $result);

//Max 8 results
        array_splice($returnArray, 8);


        echo json_encode($returnArray);
    }

    public function saveLocationAction($unitTest = null)
    {
        if ($unitTest != null) {
            $_POST = $unitTest;
        }

        if (empty($_POST['type']) || empty($_POST['name']) || empty($_POST['country']) || empty($_POST['city']) || empty($_POST['street']) || empty($_POST['housenumber']) || empty($_POST['postalcode']) || empty($_POST['email'])) {
            echo "Not everything is filled in";
            return false;
        }
        foreach ($_POST as $input) {
            if ($input == $_POST['housenumber'])
                break;

            if (strlen($input) > 254) {
                echo "Some fieldes are too long.";
                return false;
            }
            if (!preg_match('/^[A-Za-z0-9. -_]{1,31}$/', $input)) {
                echo "No special characters allowed";
                return false;
            }
        }
        if (!(filter_var($_POST['housenumber'], FILTER_VALIDATE_INT))) {
            echo "Streetnumber is not a number";
            return false;
        }

        if (!is_numeric($_POST['id'])) {
            echo "Invalid ID";
            return false;
        }

        if ($_POST['action'] != "update" && $_POST['action'] != "create") {
            echo("Invalid POST:ACTION");
            return false;
        }

        if ($_POST['type'] != "education" && $_POST['type'] != "business") {
            echo("Invalid POST:TYPE");
            return false;
        }

        if ($unitTest == null) {
            $this->saveLocationToDatabase();
        } else {
            return true;
        }
    }

    /**
     * Function to save Location to the Database
     * Also does aditional Checks
     * @return type
     */
    private function saveLocationToDatabase()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();
        if ($ac->isLoggedIn()) {

            $country = $em->getRepository('\PROJ\Entities\Country')->find($_POST['country']);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($_POST['street'] . ' ' . $_POST['housenumber'] . ', ' . $_POST['city'] . ', ' . $country->getName()) . '&sensor=false');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = json_decode(curl_exec($ch), true);

            if ($response['status'] != 'OK') {
                echo("Could not Geocode. Location was not created.");
                return;
            }

            $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID']);
            $locatie = null;
            if ($_POST['action'] == "create") {
                $locatie = new \PROJ\Entities\Institute();
                $locatie->setCreator($user->getStudent());
            } elseif ($_POST['action'] == "update") {
                $locatie = $em->getRepository('\PROJ\Entities\Institute')->find($_POST['id']);

//Extra checks
                if ($locatie->getCreator()->getAccount()->getId() == $_SESSION['userID']) {
                    if ($locatie->getAcceptanceStatus() != 0) {
                        echo "The Location has been approved while you tried to edit it.";
                        return;
                    }
                } else {
                    echo "This isn't your Location.";
                    return;
                }
            }
            $locatie->setLat($response["results"][0]["geometry"]["location"]['lat']);
            $locatie->setLng($response["results"][0]["geometry"]["location"]['lng']);
            $place = \PROJ\Helper\XssHelper::sanitizeInput($_POST['city']);
            foreach ($response["results"][0]["address_components"] as $comp) {
                if (in_array("locality", $comp["types"])) {
                    $place = $comp["long_name"];
                }
            }
            $locatie->setPlace($place);
            $locatie->setType($_POST['type']);
            $locatie->setName(\PROJ\Helper\XssHelper::sanitizeInput($_POST['name']));

            $locatie->setCountry($country);
            $locatie->setStreet(\PROJ\Helper\XssHelper::sanitizeInput($_POST['street']));
            $locatie->setHousenumber(\PROJ\Helper\XssHelper::sanitizeInput($_POST['housenumber']));
            $locatie->setPostalcode(\PROJ\Helper\XssHelper::sanitizeInput($_POST['postalcode']));
            $locatie->setEmail(\PROJ\Helper\XssHelper::sanitizeInput($_POST['email']));
            $locatie->setTelephone(\PROJ\Helper\XssHelper::sanitizeInput($_POST['telephone']));

            $em->persist($locatie);
            $em->flush();

            echo 'succes';
        }
    }

    public function saveProjectAction($unitTest = null)
    {
        if ($unitTest != null) {
            $_POST = $unitTest;
        }

        if (empty($_POST['type']) || empty($_POST['location']) || empty($_POST['start_year']) || empty($_POST['start_month']) || empty($_POST['end_year']) || empty($_POST['end_month'])) {
            echo "Not everything is filled in";
            return false;
        }

        if (!is_numeric($_POST['start_year']) || !is_numeric($_POST['start_month']) || !is_numeric($_POST['end_year']) || !is_numeric($_POST['end_month'])) {
            echo "Invalid POST";
            return false;
        }

        if ($_POST['action'] != "update" && $_POST['action'] != "create") {
            echo("Invalid POST:ACTION");
            return false;
        }

        if ($_POST['type'] != "minor" && $_POST['type'] != "internship" && $_POST['type'] != "graduation" && $_POST['type'] != "ESP") {
            echo "Invalid POST:TYPE";
            return false;
        }

        if (new \DateTime($_POST['start_year'] . '-' . $_POST['start_month'] . '-1') > new \DateTime($_POST['end_year'] . '-' . $_POST['end_month'] . '-1')) {
            echo("Start date cannot be after Stop date");
            return false;
        }

        if ($unitTest == null) {
            $this->saveProjectDatabase();
        } else {
            return true;
        }
    }

    private function saveProjectDatabase()
    {
        $ac = new \PROJ\Services\AccountService();
        if ($ac->isLoggedIn()) {
            $em = DoctrineHelper::instance()->getEntityManager();
            $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID']);
            $qb = $em->createQueryBuilder();
            $qb->select('i.id')
                    ->from('\PROJ\Entities\Institute', 'i')
                    ->where($qb->expr()->eq('i.creator', $qb->expr()->literal($user->getStudent()->getId())))
                    ->orWhere($qb->expr()->eq('i.acceptanceStatus', $qb->expr()->literal('approved')))
                    ->orderBy('i.type', 'ASC');
            $res = $qb->getQuery()->getResult();


            $found = false;
            foreach ($res as $r) {
                if ($r['id'] == $_POST['location']) {
                    $found = true;
                }
            }

            if (!$found) {
                echo "Illegal Location";
                return;
            }


            $location = $em->getRepository('\PROJ\Entities\Institute')->find($_POST['location']);
            if ($_POST['action'] == "create") {
                $project = new \PROJ\Entities\Project();
                $project->setAcceptanceStatus(Status::PENDING);
            } elseif ($_POST['action'] == "update") {
                $project = $em->getRepository('\PROJ\Entities\Project')->find($_POST['id']);

//Extra checks
                if ($project->getStudent()->getAccount()->getId() == $_SESSION['userID']) {
                    if ($project->getAcceptanceStatus() != 0) {
                        echo "The Project has been aproved while you tried to edit it.";
                        return;
                    }
                } else {
                    echo "This isn't your Project.";
                    return;
                }
            }
            $project->setInstitute($location);
            $project->setReview(null);
            $project->setStartdate(new \DateTime($_POST['start_year'] . '-' . $_POST['start_month'] . '-1'));
            $project->setendDate(new \DateTime($_POST['end_year'] . '-' . $_POST['end_month'] . '-1'));
            $project->setStudent($user->getStudent());
            $project->setType($_POST['type']);

            $em->persist($project);
            $em->flush();

            echo 'succes';
        }
    }

    public function saveReviewAction($unitTest = null)
    {
        if ($unitTest != null) {
            $_POST = $unitTest;
        }

        if (empty($_POST['project']) || (empty($_POST['assignment_score']) && @$_POST['assignment_score'] != 0) || empty($_POST['guidance_score']) || empty($_POST['accomodation_score']) || empty($_POST['overall_score']) || empty($_POST['review'])) {
            echo "Not everything is filled in";
            return false;
        }

        if (!is_numeric($_POST['project']) || !is_numeric($_POST['assignment_score']) || !is_numeric($_POST['guidance_score']) || !is_numeric($_POST['accomodation_score']) || !is_numeric($_POST['overall_score'])) {
            echo "Invalid POST:NUMERIC";
            return false;
        }

        if ($_POST['assignment_score'] > 5 || $_POST['assignment_score'] > 5 || $_POST['assignment_score'] > 5 || $_POST['guidance_score'] > 5) {
            echo "Invalid POST:SCORE";
            return false;
        }

        if ($_POST['action'] != "update" && $_POST['action'] != "create") {
            echo("Invalid POST:ACTION");
            return false;
        }

        if ($unitTest == null) {
            $this->saveReviewToDatabase();
        } else {
            return true;
        }
    }

    /**
     * Function to save Location to the Database
     * Also does aditional Checks
     * @return type
     */
    private function saveReviewToDatabase()
    {

        $ac = new \PROJ\Services\AccountService();
        if ($ac->isLoggedIn()) {
            $em = DoctrineHelper::instance()->getEntityManager();
            $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID']);

            $qb = $em->createQueryBuilder();
            $qb->select('p.id')
                    ->from('\PROJ\Entities\Project', 'p')
                    ->where($qb->expr()->eq('p.student', $qb->expr()->literal($user->getStudent()->getId())));
            $res = $qb->getQuery()->getResult();

            $found = false;
            foreach ($res as $r) {
                if ($r['id'] == $_POST['project']) {
                    $found = true;
                }
            }

            if (!$found) {
                echo "Illegal Project";
                return;
            }


            $project = $em->getRepository('\PROJ\Entities\Project')->find($_POST['project']);
            $review = getReviewEntitie();
            if ($review == null) {
                return;
            }


            if (count($em->getRepository('\PROJ\Entities\Review')->findBy(array('project' => $_POST['project']))) > 0 && $_POST['project'] != $review->getProject()->getId()) {
                echo "You can only create one review per location";
                return;
            }


            $review->setAccommodationRating($_POST['assignment_score']);
            $review->setAssignmentRating($_POST['guidance_score']);
            $review->setGuidanceRating($_POST['accomodation_score']);
            $review->setProject($project);
            $review->setRating($_POST['overall_score']);
            $review->setText(\PROJ\Helper\XssHelper::sanitizeInput($_POST['review']));

            $em->persist($review);
            $em->flush();

            echo 'succes';
        }
    }

    private function getReviewEntitie()
    {
        if ($_POST['action'] == "create") {
            $review = new \PROJ\Entities\Review();
            $review->setAcceptanceStatus(Status::PENDING);
        } elseif ($_POST['action'] == "update") {
            $review = $em->getRepository('\PROJ\Entities\Review')->find($_POST['id']);

//Extra checks
            if ($review->getProject()->getSTudent()->getAccount()->getId() == $_SESSION['userID']) {
                if ($review->getAcceptanceStatus() != 0) {
                    echo "The Review has been approved while you tried to edit it.";
                    return null;
                }
            } else {
                echo "This isn't your Review.";
                return null;
            }
        }

        return $review;
    }

    public function getReviewInfoAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();

        if (!is_numeric($_POST['id'])) {
            echo "Illegal ID";
            return;
        }
        if ($ac->isLoggedIn()) {
            $rev = $em->getRepository('\PROJ\Entities\Review')->find($_POST['id']);
            if ($rev->getProject()->getStudent()->getAccount()->getId() == $_SESSION['userID']) {
                if ($rev->getAcceptanceStatus() == 0) {
                    echo json_encode($rev->jsonSerialize());
                } else {
                    echo "The Review has been approved while you tried to delete it.";
                }
            } else {
                echo "This isn't your Review.";
            }
        }
    }

    public function getLocationInfoAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();

        if (!is_numeric($_POST['id'])) {
            echo "Illegal ID";
            return;
        }
        if ($ac->isLoggedIn()) {
            $inst = $em->getRepository('\PROJ\Entities\Institute')->find($_POST['id']);
            if ($inst->getCreator()->getAccount()->getId() == $_SESSION['userID']) {
                if ($inst->getAcceptanceStatus() == 0) {
                    echo json_encode($inst->jsonSerialize());
                } else {
                    echo "The Location has been approved while you tried to delete it.";
                }
            } else {
                echo "This isn't your Location.";
            }
        }
    }

    public function removeLocationAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();

        if (!is_numeric($_POST['id'])) {
            echo "Illegal ID";
            return;
        }
        if ($ac->isLoggedIn()) {
            $inst = $em->getRepository('\PROJ\Entities\Institute')->find($_POST['id']);
            if ($inst->getCreator()->getAccount()->getId() == $_SESSION['userID']) {
                if ($inst->getAcceptanceStatus() == 0) {
                    if ($inst->getProjects() != null) {
                        foreach ($inst->getProjects() as $proj) {
                            if ($proj->getReview() != null) {
                                foreach ($proj->getReview() as $rev) {
                                    $em->remove($rev);
                                }
                            }
                            $em->remove($proj);
                        }
                    }
                    $em->remove($inst);
                    $em->flush();
                    echo "succes";
                } else {
                    echo "The Location has been approved while you tried to delete it.";
                }
            } else {
                echo "This isn't your Location.";
            }
        }
    }

    public function getAllCountriesAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $inst = $em->getRepository('\PROJ\Entities\Country')
                ->createQueryBuilder('e')
                ->select('e')
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return json_encode($inst);
    }

    public function removeReviewAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();

        if (!is_numeric($_POST['id'])) {
            echo "Illegal ID";
            return;
        }
        if ($ac->isLoggedIn()) {
            $rev = $em->getRepository('\PROJ\Entities\Review')->find($_POST['id']);
            if ($rev->getProject()->getStudent()->getAccount()->getId() == $_SESSION['userID']) {
                if ($rev->getAcceptanceStatus() == 0) {
                    $em->remove($rev);
                    $em->flush();
                    echo "succes";
                } else {
                    echo "The Review has been approved while you tried to delete it.";
                }
            } else {
                echo "This isn't your Review.";
            }
        }
    }

    public function removeProjectAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();

        if (!is_numeric($_POST['id'])) {
            echo "Illegal ID";
            return;
        }
        if ($ac->isLoggedIn()) {
            $proj = $em->getRepository('\PROJ\Entities\Project')->find($_POST['id']);
            if ($proj->getStudent()->getAccount()->getId() == $_SESSION['userID']) {
                if ($proj->getAcceptanceStatus() == 0) {
                    if ($proj->getReview() != null) {
                        foreach ($proj->getReview() as $rev) {
                            $em->remove($rev);
                        }
                    }
                    $em->remove($proj);
                    $em->flush();
                    echo "succes";
                } else {
                    echo "The Project has been aproved while you tried to delete it.";
                }
            } else {
                echo "This isn't your Project.";
            }
        }
    }

    public function getMyLocationsInfoAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $ac = new \PROJ\Services\AccountService();

        if (!is_numeric($_POST['id'])) {
            echo "Illigal ID";
            return;
        }
        if ($ac->isLoggedIn()) {
            $proj = $em->getRepository('\PROJ\Entities\Project')->find($_POST['id']);
            if ($proj->getStudent()->getId() == $_SESSION['userID']) {
                if ($proj->getAcceptanceStatus() == 0) {
                    echo json_encode($proj->jsonSerialize());
                } else {
                    echo "The Project has been aproved while you tried to delete it.";
                }
            } else {
                echo "This isn't your Project.";
            }
        }
    }

}
