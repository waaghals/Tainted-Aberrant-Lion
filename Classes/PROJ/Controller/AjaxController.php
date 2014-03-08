<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PROJ\Controller;

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

    public function allLocationsAction($type = "all") {
        switch ($type) {
            case "minor":
                break;
            case "internship":
                break;
            case "esp":
                break;
            case "all":
            default:
                echo file_get_contents(__DIR__ . "/../../../js/tempTestMarkers.json");
                break;
        }
    }

    public function locationReviewAction($lid = 1) {
        //TODO get location base on $lid (location id)
        echo file_get_contents(__DIR__ . "/../../../js/testReviews.json");
    }

}
