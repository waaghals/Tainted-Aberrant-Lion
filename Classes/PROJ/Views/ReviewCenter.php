<?php

namespace PROJ\Views;

class ReviewCenter {

    public function getContent() {
        $r = null;

        //Get all reviews (till login and db are working)
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $reviews = $em->getRepository('\PROJ\Entities\Review')->findAll();


        $r .= "<h1>Goedgekeurde reviews</h1>"
                . "<form name='review' action='/ReviewCenter/' method='post'>";
        foreach ($reviews as $rev) {
            //$rev.getStage().getInstelling().getName()
            $r.= "<div class='review_left_col'>"
                    . "<a href='?editreview=".$rev->getId()."'>left</a>"
                    . "</div>"
                    . "<div class='review_right_col'>"
                    . "mid"
                    . "</div>";
        }

        $r.= "</form>";

        return $r;
    }

}
