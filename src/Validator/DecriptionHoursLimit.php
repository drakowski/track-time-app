<?php

declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
final class DecriptionHoursLimit extends Constraint
{
    public ?string $message = 'registerWorkingTime.exceeded_working_hours_limit';
    public ?string $startField;
    public ?string $endField;

    public function __construct(
        ?string $message = null,
        ?string $startField = null,
        ?string $endField = null,
        ?array $groups = null,
        $payload = null,
        array $options = []
    ) {
        $this->startField = $startField;
        $this->endField = $endField;
        $this->message = $message ?? $this->message;

        parent::__construct($options, $groups, $payload);
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
