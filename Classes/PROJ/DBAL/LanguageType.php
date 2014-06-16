<?php

namespace PROJ\DBAL;

class LanguageType extends EnumType
{

    const ENGLISH = 'english';
    const DUTCH = 'dutch';

    protected $name = 'languagetype';
    protected $values = array(self::ENGLISH, self::DUTCH);

}
