<?php

namespace PROJ\DBAL;

class ApprovalStateType extends EnumType
{

    const PENDING = 'pending';
    const APPROVED = 'approved';
    const DECLINED = 'declined';

    protected $name = 'projectstate';
    protected $values = array(self::PENDING, self::APPROVED, self::DECLINED);

}
