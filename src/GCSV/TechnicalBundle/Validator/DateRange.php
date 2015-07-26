<?php

namespace GCSV\TechnicalBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateRange extends Constraint
{
    public $message = "Podałeś nieprawidłowy zakres dat. Data zakończenia wizyty nie może być mniejsza niż data rozpoczęcia wizyty: %data%.";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
} 