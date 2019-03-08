<?php

namespace App\Validator;

use \App\Entity\Flight;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AirportValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\Airport */
        /* @var $value Flight */

        if ($value->getArrival()->getId() === $value->getDeparture()->getId()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
