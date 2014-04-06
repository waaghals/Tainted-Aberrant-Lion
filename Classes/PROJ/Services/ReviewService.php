<?php

namespace PROJ\Services;

use \PROJ\Helper\DoctrineHelper;

class ReviewService {

    public function addReview($data) {
        $em = DoctrineHelper::instance()->getEntityManager();
        $newReview = new \PROJ\Entities\Review();
        $newReview->setProject($em->getRepository('PROJ\Entities\Project')->findOneBy(array('id' => $data['id'])));
        $newReview->setText($data['review']);
        $newReview->setAssignmentRating($data['assrating']);
        $newReview->setAccommodationRating($data['accrating']);
        $newReview->setGuidanceRating($data['guirating']);
        $em->persist($newReview);
        $em->flush();
    }

    public function editReview($id, $data) {
        $em = DoctrineHelper::instance()->getEntityManager();
        $editReview = $em->getRepository('PROJ\Entities\Review')->findOneBy(array('id' => $id));
        $editReview->setText($data['review']);
        $editReview->setAssignmentRating($data['assrating']);
        $editReview->setAccommodationRating($data['accrating']);
        $editReview->setGuidanceRating($data['guirating']);
        $em->persist($editReview);
        $em->flush();
    }

    public function getReview($id) {
        $em = DoctrineHelper::instance()->getEntityManager();
        return $em->getRepository('PROJ\Entities\Review')->findOneBy(array('id' => $id));
    }

    public function loadReviewCenter() {
        $em = DoctrineHelper::instance()->getEntityManager();
        return $em->getRepository('PROJ\Entities\Project')->findBy(array('student' => $_SESSION['user']->getStudent()));
    }

}
