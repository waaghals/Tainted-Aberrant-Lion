<?php
namespace PROJ\Pages;

class ReviewCenter extends MainPage {

    public function getContent() {
    $reviewCenter = new \PROJ\View\ReviewCenter;

        $r = $reviewCenter->getContent();

        return $r;
    }
}

