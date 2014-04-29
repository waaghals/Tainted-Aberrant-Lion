<?php

namespace PROJ\DBAL;

class InstituteType extends EnumType
{

    const EDUCATION = 'education';
    const BUSINESS = 'business';

    protected $name = 'institutetype';
    protected $values = array(self::EDUCATION, self::BUSINESS);

}
