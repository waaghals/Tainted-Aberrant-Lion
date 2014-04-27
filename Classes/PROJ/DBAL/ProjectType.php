<?php

namespace PROJ\DBAL;

class ProjectType extends EnumType
{

    protected $name = 'projecttype';
    protected $values = array('minor', 'internship', 'graduation', 'ESP');

}
