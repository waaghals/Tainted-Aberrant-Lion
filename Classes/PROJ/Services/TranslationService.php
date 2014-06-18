<?php

namespace PROJ\Services;

use PROJ\Exceptions\ServerException;

class TranslationService
{

    private $em;

    function __construct()
    {
        $this->em = \PROJ\Helper\DoctrineHelper::instance()->getEntityManager();
    }

    public function translate($sentenceKey)
    {

        if (!isset($_SESSION['language']) || empty($_SESSION['language'])) {
            $_SESSION['language'] = "english";
        }

        $translation = $this->em->getRepository('PROJ\Entities\Translation')->findOneBy(array(
            'sentenceKey' => strtolower($sentenceKey), 'language' => $_SESSION["language"]));
        if (empty($translation)) {
            return "There is no translation";
        }
        return $translation->getTranslation();
    }

    public function translateAll($sentenceKeyArray)
    {

        $array = array();

        foreach ($sentenceKeyArray as $sentenceKey) {
            $array[$sentenceKey] = $this->translate($sentenceKey);
        }

        return $array;
    }

}
