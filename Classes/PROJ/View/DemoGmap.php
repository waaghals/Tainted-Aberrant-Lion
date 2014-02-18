<?php

namespace PROJ\View;

class DemoGmap {

    public function getContent() {
        if (@!strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //Map weergeven
            $gmap = new \PROJ\Classes\GoogleMap();
            $gmap->setCenterLocation("Hilversum");
            $gmap->setZoom(9);
            $gmap->setStyle("width:100%; height:100%;");
            $gmap->setMarkerURL("/GoogleMap/");
            $gmap->setAllowStreetView(false);

            $sHtml = null;
            $sHtml .= '<div id="blackout">'
                    . '     <div id="blackout_content"></div>'
                    . '</div>'
                    . '<div id="legenda">'
                    . '     <h3 style="margin-bottom:5px;">Legend:</h3>'
                    . '     <table>'
                    . '         <tr>'
                    . '             <td><img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|FE7569"></td>'
                    . '             <td style="padding-left:10px; padding-right:40px;">Internship</td>'
                    . '         </tr><tr>'
                    . '             <td><img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|58D2FF"></td>'
                    . '             <td style="padding-left:10px; padding-right:40px;">Minor</td>'
                    . '         </tr><tr>'
                    . '             <td><img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|58E579"></td>'
                    . '             <td style="padding-left:10px; padding-right:40px;">Internship & Minor</td>'
                    . '         </tr>'
                    . '     </table>'
                    . '</div>';
            $sHtml .= $gmap->getHtml();

            return $sHtml;
        } else {
            //Markers terug geven
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
                if($avg[0]['AANTALREVIEWS'] == 0)
                    $markerHtml .= "<br><br>Er zijn nog geen reviews geschreven voor " . $rev->getNaam() . "</div>";
                else
                    $markerHtml .= "<br><br><a href='#' class='AllReviews' instantie='".$rev->getId()."'>Alle (".$avg[0]['AANTALREVIEWS'].") Reviews Bekijken</a></div>";

                $demoMarker->setHtml($markerHtml);
                $demoMarker->setTitle($rev->getNaam());

                $mc->addMarkerLocation($rev->getNaam(), $demoMarker);
            }
            return $mc->generateMarkerJSON();
        }
    }

}

?>