<?php

namespace App\Validator;

use \App\Entity\Crash;
use App\Repository\CrashRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PlaneCrashValidator extends ConstraintValidator
{
    /**
     * @var CrashRepository
     */
    private $crashRepository;

    public function __construct(CrashRepository $crashRepository)
    {
        $this->crashRepository = $crashRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint App\Validator\PlaneCrash */
        /* @var $value Crash */

        $query = $this->crashRepository->createQueryBuilder("c");
        $results = $query->join("c.flight", "f")
            ->join("f.plane", "p")
            ->where("p.id = :plane_id")
            ->setParameter("plane_id", $value->getFlight()->getPlane()->getId())
            ->getQuery()->getResult();

        if (count($results) >= 1) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
