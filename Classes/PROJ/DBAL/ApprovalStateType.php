<?php

namespace PROJ\DBAL;

class ApprovalStateType extends EnumType
{

    protected $name = 'projectstate';
    protected $values = array('pending', 'approved', 'declined');

}
