<?php

namespace PROJ\Controller;

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
        $reviews = $em->getRepository('\PROJ\Entities\Instelling')->findAll();

        foreach ($reviews as $rev) {
            //Gemiddelde score berekenen
            $qb = $em->createQueryBuilder();
            $qb->select('avg(review.rating) as AVGSCORE, count(review.id) as AANTALREVIEWS')
                    ->from('\PROJ\Entities\Instelling', 'instelling')
                    ->leftJoin('instelling.stages', 'stage')
                    ->leftJoin('stage.review', 'review')
                    ->where($qb->expr()->eq('instelling.id', $qb->expr()->literal($rev->getId())));
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
            $demoMarker->setTitle($rev->getNaam());

            $mc->addMarkerLocation($rev->getNaam(), $demoMarker);
        }
        echo $mc->generateMarkerJSON();
    }

    public function allLocationsAction() {
        $em = DoctrineHelper::instance()->getEntityManager();
        $instances = $em->getRepository('\PROJ\Entities\Instelling')->findAll();

        echo json_encode($instances);
        return;
        $dql = "SELECT i FROM \PROJ\Entities\Instelling i JOIN i.stages s";
        $q = $em->createQuery($dql);

        $res = $q->getArrayResult();
        \Doctrine\Common\Util\Debug::dump($res, 3);
/*
        foreach ($res as $row) {
           $row = array_map(function($stage) {
                return array(
                    "start" => $stage->startDatum()
                );
            }, $row->getStages()); 
            \Doctrine\Common\Util\Debug::dump($row->getStages(), 3);
            echo json_encode($row);
        } 
        */
    }

    public function locationReviewAction($lid = 1) {
        $lid = intval($lid);

        if (!is_int($lid)) {
            $msg = "Not a valid location id.";
            throw new ServerException($msg, ServerException::SERVER_ERROR);
        }

        $em = DoctrineHelper::instance()->getEntityManager();
        $instances = $em->getRepository('\PROJ\Entities\Instelling')->find($lid);

        echo json_encode($instances);
    }
    
    public function getProjectInfo($tag){
        $tag = filter_var($tag, FILTER_SANITIZE_STRING);
        $em = DoctrineHelper::instance()->getEntityManager();
        $results = $em->getRepository('\PROJ\Entities\Project');
    }

}
