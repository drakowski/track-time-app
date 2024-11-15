<?php

declare(strict_types=1);

namespace App\Request;

use App\Enum\RegisterWorkingTimeEnum;
use App\Validator\DecriptionHoursLimit;
use Symfony\Component\Validator\Constraints as Assert;

#[DecriptionHoursLimit(
    startField: 'startDateTime',
    endField: 'endDateTime',
)]
final readonly class RegisterWorkingTimeRequest
{
    public function __construct(
        #[Assert\DateTime(format: RegisterWorkingTimeEnum::DATE_TIME_FORMAT->value, message: 'registerWorkingTime.startDateTime.formatInvalid')]
        private string $startDateTime,
        #[Assert\DateTime(format: RegisterWorkingTimeEnum::DATE_TIME_FORMAT->value, message: 'registerWorkingTime.endDateTime.formatInvalid')]
        private string $endDateTime
    ) {
    }


    public function getStartDateTime(): string
    {
        return $this->startDateTime;
    }

    public function getEndDateTime(): string
    {
        return $this->endDateTime;
    }
}
