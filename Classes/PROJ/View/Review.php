<?php

namespace PROJ\View;

class Review {

    public function getContent() {
        $r = null;

        $r .= "<h1>Review</h1>"
                . "<form name='review' action='/Review/' method='post'>"
                . "<div class='review_left_col'>"
                . "Review de instantie:"
                . "</div>"
                . "<div class='review_right_col'>"
                . "<textarea name='review' cols='50' rows='10'></textarea>"
                . "</div>"
                . "<div class='review_left_col'>"
                . "Geef de instantie een cijfer:"
                . "</div>"
                . "<div class='login_right_col'>"
                . "<select name='rating'>"
                . "<option value='1'>1</option>"
                . "<option value='2'>2</option>"
                . "<option value='3'>3</option>"
                . "<option value='4'>4</option>"
                . "<option value='5'>5</option>"
                . "</select>"
                . "</div>"
                . "<div class='review_left_col'>"
                . "</div>"
                . "<div class='review_right_col'>"
                . "     <input type='submit' name='reviewButton'>"
                . "</div>"
                . "</form>";

        return $r;
    }

}
