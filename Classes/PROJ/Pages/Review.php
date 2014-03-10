<?php

namespace PROJ\Pages;

class Review extends MainPage {

    public function getContent() {
        $review = new \PROJ\View\Review;

        if(isset($_POST['reviewButton'])) {
            //Submit button pressed
            
        }
        
        $r = $review->getContent();

        return $r;
    }

}
