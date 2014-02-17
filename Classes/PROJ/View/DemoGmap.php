<?php

namespace PROJ\View;

class DemoGmap {

    public function getContent() {
       if(@!strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //Map weergeven
            $gmap = new \PROJ\Classes\GoogleMap();
            $gmap->setCenterLocation("Hilversum");
            $gmap->setZoom(9);
            $gmap->setStyle("width:100%; height:100%;");
            $gmap->setMarkerURL("/GoogleMap/");
            $gmap->setAllowStreetView(false);

            $sHtml = null;
            $sHtml .= '<div id="blackout"><div id="blackout_content"></div></div>';
            $sHtml .= $gmap->getHtml();
            
            return $sHtml;
        }else{
            //Markers terug geven
            $mc = new \PROJ\Classes\MarkerCollection();

            //Alle Instellingen ophalen
            $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
            $reviews = $em->getRepository('\PROJ\Entities\Instelling')->findAll();
            $qb = $em->createQueryBuilder();
            $qb->select('instelling, avg(review.rating) as AVGSCORE')
                    ->from('\PROJ\Entities\Instelling', 'instelling')
                    ->leftJoin('instelling.stages', 'stage')
                    ->leftJoin('stage.review', 'review');
            
            $reviews = $qb->getQuery()->getResult();
            
            foreach($reviews as $rev) {
                $demoMarker = new \PROJ\Classes\Marker();
                $demoMarker->setLat($rev[0]->getLat());
                $demoMarker->setLong($rev[0]->getLong());
                $demoMarker->setHtml("<div style='width:400px; height:200px;'><h4>".$rev[0]->getNaam()."</h4><br>"
                        . "Gemiddelde Score: ".number_format($rev['AVGSCORE'], 1)."<br><br><a href='#' class='AllReviews' instantie='".$rev[0]->getId()."'>Alle Reviews Bekijken</a></div>");
                $demoMarker->setTitle("Avans Hogeschool");

                $mc->addMarkerLocation("Avans Hogeschool", $demoMarker);
            }
            return $mc->generateMarkerJSON();
        }
    }

}

?>