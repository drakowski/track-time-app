<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\WorkingTime;
use App\Enum\RegisterWorkingTimeEnum;
use App\Exceptions\AlreadyExistsException;
use App\Repository\WorkingTimeRepository;
use App\Request\RegisterWorkingTimeRequest;
use App\Utils\HoursUtils;
use DateTimeImmutable;

final readonly class RegisterWorkingTimeService implements RegisterWorkingTimeServiceInterface
{
    public function __construct(private WorkingTimeRepository $workingTimeRepository)
    {

    }

    /**
     * @throws AlreadyExistsException
     */
    public function register(string $employeeUuid, RegisterWorkingTimeRequest $registerWorkingTimeRequest): void
    {
        $startDateTime = $this->createDateTimeImmutable($registerWorkingTimeRequest->getStartDateTime());

        $startWorkingTimeLabel = $startDateTime->format('Y-m-d');

        if ($this->workingTimeRepository->existsByEmployeeUuidAndStartDateLabel($employeeUuid, $startWorkingTimeLabel)) {
            throw new AlreadyExistsException();
        }

        $endDateTime = $this->createDateTimeImmutable($registerWorkingTimeRequest->getEndDateTime());

        $this->workingTimeRepository->store(new WorkingTime(
            $employeeUuid,
            $startDateTime,
            $endDateTime,
            $startWorkingTimeLabel,
            HoursUtils::diffInString($startDateTime, $endDateTime)
        ));
    }

    private function createDateTimeImmutable(string $dateTimeString, string $format = RegisterWorkingTimeEnum::DATE_TIME_FORMAT->value): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat($format, $dateTimeString);
    }
}
