<?php

namespace GCSV\TechnicalBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class DateRangeValidator extends ConstraintValidator
{
    public function validate($entity, Constraint $constraint)
    {
        if ($entity->getRozpoczecieWizyty() > $entity->getZakonczenieWizyty()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('zakonczenieWizyty')
                ->setParameter('%data%', $entity->getRozpoczecieWizyty()->format('d.m.Y'))
                ->addViolation();
        }
    }
} 