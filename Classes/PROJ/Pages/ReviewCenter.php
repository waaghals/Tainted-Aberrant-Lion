<?php
namespace PROJ\Pages;

class ReviewCenter extends MainPage {

    public function getContent() {
    $reviewCenter = new \PROJ\Views\ReviewCenter;

        $r = $reviewCenter->getContent();

        return $r;
    }
}

