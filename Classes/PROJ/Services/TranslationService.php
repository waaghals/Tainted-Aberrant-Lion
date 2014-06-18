<?php

namespace PROJ\Services;

use PROJ\Exceptions\ServerException;
use PROJ\DBAL\LanguageType;

class TranslationService {
    
    private $repo;
    
    function __construct() 
    { 
        $this->repo = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager()->getRepository('PROJ\Entities\Translation');
    } 

    public function translate($sentenceKey) {

        if (!isset($_SESSION['language']) || empty($_SESSION['language'])) {
            $_SESSION['language'] = LanguageType::ENGLISH;
        }

        $translation = $this->repo->findOneBy(array('sentenceKey' => strtolower($sentenceKey), 'language' => $_SESSION["language"]));
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
