<?php

namespace PROJ\DBAL;

class ProjectType extends EnumType
{

    const MINOR = 'minor';
    const INTERNSHIP = 'internship';
    const GRADUATION = 'graduation';
    const EPS = 'esp';

    protected $name = 'projecttype';
    protected $values = array(self::MINOR, self::INTERNSHIP, self::GRADUATION, self::EPS);

}
