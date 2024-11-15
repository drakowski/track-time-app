<?php

declare(strict_types=1);

namespace App\Validator;

use App\Enum\RegisterWorkingTimeEnum;
use App\Utils\HoursUtils;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class DecriptionHoursLimitValidator extends ConstraintValidator
{
    private const int HOURS_DIFF_LIMIT = 12;

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof DecriptionHoursLimit) {
            throw new UnexpectedTypeException($constraint, DecriptionHoursLimit::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_object($value) || !property_exists($value, $constraint->startField) || !property_exists(
            $value,
            $constraint->endField
        )) {
            throw new UnexpectedValueException(
                $value,
                'object with properties ' . $constraint->startField . ' and ' . $constraint->endField
            );
        }

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $startDateTime =  DateTimeImmutable::createFromFormat(RegisterWorkingTimeEnum::DATE_TIME_FORMAT->value, $propertyAccessor->getValue($value, $constraint->startField));
        $endDateTime = DateTimeImmutable::createFromFormat(RegisterWorkingTimeEnum::DATE_TIME_FORMAT->value, $propertyAccessor->getValue($value, $constraint->endField));

        if (!$startDateTime instanceof DateTimeInterface || !$endDateTime instanceof DateTimeInterface) {
            throw new UnexpectedValueException($startDateTime, 'DateTimeInterface');
        }

        if (HoursUtils::diffInHours($startDateTime, $endDateTime) > self::HOURS_DIFF_LIMIT) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ limit }}', (string)self::HOURS_DIFF_LIMIT)
                ->addViolation();
        }
    }
}
