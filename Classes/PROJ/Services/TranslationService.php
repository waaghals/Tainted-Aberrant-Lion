<?php

namespace PROJ\Services;

use PROJ\Exceptions\ServerException;

class TranslationService {

    public static function translate($sentenceId) {

        if (!isset($_SESSION['language']) || empty($_SESSION['language'])) {
            $_SESSION['language'] = "english";
        }

        $em = DoctrineHelper::instance()->getEntityManager();
        $translation = $em->getRepository('PROJ\Entities\Translation')->findOneBy(array('sentenceId' => $sentenceId), array('language' => $_SESSION["language"]));
        
        return $translation->getTranslation();
    }

    public static function translateAll($sentenceIdArray) {
        
        $array = array();
        
        foreach(@sentenceIdArray as $sentenceId){
            $array[] = $this->translate($sentenceId);
        }
        
        return $array;
    }

}
