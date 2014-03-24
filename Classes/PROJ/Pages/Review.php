<?php

namespace PROJ\Pages;

class Review extends MainPage {

    public function getContent() {
        $review = new \PROJ\Views\Review;

        if (isset($_POST['reviewButton'])) {

            $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
            $newReview = new \PROJ\Entities\Review();
            $newReview->setText($_POST['review']);
            $newReview->setRating($_POST['rating']);
            $em->persist($newReview);
            $em->flush();
        }

        $r = $review->getContent();

        return $r;
    }

}
