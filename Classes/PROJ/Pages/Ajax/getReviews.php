<?php

namespace PROJ\Pages\Ajax;

class getReviews extends \PROJ\Pages\MainPage {

    public function getContent() {
        $r = null;
        if(@$_POST['instantie'] != "") {
            $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
            $stages = $em->getRepository('\PROJ\Entities\Instelling')->find($_POST['instantie'])->getStages();
            
            $r .= "<h3 style='margin-bottom:5px;'>Reviews:</h3>";
            foreach($stages as $stage) {
                if($stage->getReview() != null) {
                    $r .= "<hr>"
                            . "<div style='text-align:right; width:100%;'>Review door: ".$stage->getStudent()->getVoornaam()." ".$stage->getStudent()->getAchternaam()."</div><br>"
                            . "<span style='font-style:italic'>".$stage->getReview()->getText()."</span><br>"
                            . "<b>Addignment Rating: ".$stage->getReview()->getAssignmentRating()."</b>"
                            . "<b>Accomodation Rating: ".$stage->getReview()->getAccommodationRating()."</b>"
                            . "<b>Guidance Rating: ".$stage->getReview()->getGuidanceRating()."</b>"
                            . "<hr>";
                }
            }
        }
        return $r;
    }
    
    public function isHtml() {
        return false;
    }

}

?>