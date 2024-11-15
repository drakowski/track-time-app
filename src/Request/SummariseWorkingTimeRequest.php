<?php

declare(strict_types=1);

namespace App\Request;

final readonly class SummariseWorkingTimeRequest
{
    public function __construct(
        private string $employeeUuid,
        private string $startDateLabel,
        private int $monthlyWorkingHoursQuota,
        private int $hourlyRate,
        private int $hourlyOvertimeRatePercent,
    ) {
    }

    public function getEmployeeUuid(): string
    {
        return $this->employeeUuid;
    }

    public function getStartDateLabel(): string
    {
        return $this->startDateLabel;
    }

    public function getMonthlyWorkingHoursQuota(): int
    {
        return $this->monthlyWorkingHoursQuota;
    }

    public function getHourlyRate(): int
    {
        return $this->hourlyRate;
    }

    public function getHourlyOvertimeRatePercent(): int
    {
        return $this->hourlyOvertimeRatePercent;
    }
}
