<?php

namespace PROJ\Pages;

class Review extends MainPage {

    public function getContent() {
        $review = new \PROJ\Views\Review;

        if (isset($_POST['reviewButton'])) {

            $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
            $newReview = new \PROJ\Entities\Review();
            $newReview->setText($_POST['review']);
            $newReview->setAssignmentRating($_POST['assrating']);
            $newReview->setAccommodationRating($_POST['accrating']);
            $newReview->setGuidanceRating($_POST['guirating']);
            $em->persist($newReview);
            $em->flush();
        }

        $r = $review->getContent();

        return $r;
    }

}
