<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PROJ\Helper;

/**
 * @author Thijs
 */
class RightHelper
{

    /**
     * Check if the user that is logged in as has a certain right.
     * @param string $rightName
     * @return boolean
     */
    public static function loggedUserHasRight($rightName)
    {
        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $user = $em->getRepository('\PROJ\Entities\Account')->find($_SESSION['userID']);
        if ($user != null) {
            if ($user->getRightgroup() != null) {
                foreach ($user->getRightgroup()->getRights() as $right) {
                    if ($right->getName() == $rightName) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Check if a user has a certain right.
     * @param object $account
     * @param string $rightName
     * @return boolean
     */
    public static function userHasRight($account, $rightName)
    {
        if ($account != null) {
            foreach ($account->getRightgroup()->getRights() as $right) {
                if ($right->getName() == $rightName) {
                    return true;
                }
            }
        }

        return false;
    }

}
