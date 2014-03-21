<?php

namespace PROJ\Controllers;

use PROJ\Tools\Template;
use PROJ\Services\AccountService;
use PROJ\Services\ReviewService;
use PROJ\Helper\HeaderHelper;

class ReviewController extends BaseController {

    private $reviewService;
    private $accountService;

    public function __construct() {
        $this->accountService = new AccountService();
        $this->accountService->doLogin("admin");

        if (!$this->accountService->isLoggedIn())
        #hier komt een error, maar niemand reageerde op vraag :P
            HeaderHelper::redirect();

        $this->reviewService = new ReviewService();
    }

    public function IndexAction() {
        $t = new Template("ReviewCenter");
        $t->projects = $this->reviewService->loadReviewCenter();
        echo $t;
    }

    public function AddAction($ProjectId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->reviewService->addReview($_POST);
        }
        $t = new Template("Review");
        $t->id = $ProjectId;
        $t->text = "";
        echo $t;
    }

    public function EditAction($ReviewId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->reviewService->editReview($ReviewId, $_POST);
        }
        $review = $this->reviewService->getReview($ReviewId);
        $t = new Template("Review");
        $t->text = (string) $review->gettext();
        $t->grade = (int) $review->getrating();
        echo $t;
    }

}
