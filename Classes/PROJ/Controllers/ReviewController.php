<?php

namespace PROJ\Controllers;

use PROJ\Helper\HeaderHelper;
use PROJ\Tools\Template;

class ReviewController extends BaseController {

    public function IndexAction() {
       $t = new Template("ReviewCenter");
        echo $t; 
    }

    public function AddAction() {
        $t = new Template("Review");
        $t->text = "";
        echo $t;
    }

    public function EditAction($ReviewId) {

        $t = new Template("Review");
        $t->text = "hallo";
        $t->grade = 3;
        echo $t;
    }

}
