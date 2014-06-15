<?php

namespace PROJ\Services;

use PROJ\Exceptions\ServerException;

class TranslationService {

    public function translate($sentenceKey) {

        if (!isset($_SESSION['language']) || empty($_SESSION['language'])) {
            $_SESSION['language'] = "english";
        }

        $em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
        $translation = $em->getRepository('PROJ\Entities\Translation')->findOneBy(array('sentenceKey' => strtolower($sentenceKey), 'language' => $_SESSION["language"]));
        return $translation->getTranslation();
    }

    public function translateAll($sentenceKeyArray) {
        
        $array = array();
        
        foreach($sentenceKeyArray as $sentenceKey){
            $array[$sentenceKey] = $this->translate($sentenceKey);
        }
        
        return $array;
    }

}
