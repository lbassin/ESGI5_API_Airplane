<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Airport extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Le vol de depart et d\'arriver ne peuvent pas être semblable, tu tournes en rond';

    public function getTargets()
    {
        return [self::CLASS_CONSTRAINT];
    }
}
