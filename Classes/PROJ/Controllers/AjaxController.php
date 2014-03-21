<?php

namespace PROJ\Controllers;

use PROJ\Exceptions\ServerException;
use PROJ\Helper\DoctrineHelper;

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

    public function allLocationsAction()
    {
        $em = DoctrineHelper::instance()->getEntityManager();
        $instances = $em->getRepository('\PROJ\Entities\Institute')->findAll();

        echo json_encode($instances);
        return;
        $dql = "SELECT i FROM \PROJ\Entities\Institute i JOIN i.projects s";
        $q = $em->createQuery($dql);

        $res = $q->getArrayResult();
        \Doctrine\Common\Util\Debug::dump($res, 3);
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
        $tag = filter_var($_POST['tag'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $em = DoctrineHelper::instance()->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select(array('review.text', 'institute.lat', 'institute.long'))
                ->from('\PROJ\Entities\Review', 'review')->leftJoin('review.project', 'project')->leftJoin('project.institute', 'institute')
                ->where($qb->expr()->like("review.text", $qb->expr()->literal("%" . $tag . "%")));

        $result = $qb->getQuery()->getResult();
 

        for ($i = 0; $i < count($result); $i++) {
            $result[$i]["text"] = substr($result[$i]["text"], 0, 50);
        }

        echo json_encode($result);
    }

}
