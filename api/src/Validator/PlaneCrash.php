<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PlaneCrash extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Un avion ne peut pas se crasher plusieurs fois, quand t\'es mort t\'es mort';

    public function getTargets()
    {
        return [self::CLASS_CONSTRAINT];
    }
}
