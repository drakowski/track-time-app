<?php

declare(strict_types=1);

namespace App\Services\Decorators;

use App\DTO\SummaryDTO;
use App\Enum\SummaryDTOAttributeEnum;
use App\Repository\WorkingTimeRepository;
use App\Request\SummariseWorkingTimeRequest;
use App\Utils\HoursUtils;

final class TotalHoursDecorator implements SummariseWorkingTimeDecoratorInterface
{
    public function __construct(private readonly WorkingTimeRepository $workingTimeRepository)
    {

    }

    public function decorate(SummaryDTO $summaryDTO, SummariseWorkingTimeRequest $summariseWorkingTimeRequest): void
    {
        $startDateLabel = $summariseWorkingTimeRequest->getStartDateLabel();
        $startDate = $this->workingTimeRepository->findMinStartDateTime($startDateLabel, $summariseWorkingTimeRequest->getEmployeeUuid());
        $endDate = $this->workingTimeRepository->findMaxEndDateTime($startDateLabel, $summariseWorkingTimeRequest->getEmployeeUuid());
        $hoursDiff = HoursUtils::diffInHours($startDate, $endDate);
        $minuteDiff = HoursUtils::diffInMinutes($startDate, $endDate);

        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::TOTAL_HOURS->value, $hoursDiff);
        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::TOTAL_MINUTES->value, $minuteDiff);
        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::TOTAL_HOURS_AND_MINUTES->value, $hoursDiff . ":" . $minuteDiff);
    }

}
