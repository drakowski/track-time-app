<?php

declare(strict_types=1);

namespace App\Services\Decorators;

use App\DTO\Attribute\AttributeDTO;
use App\DTO\SummaryDTO;
use App\Enum\SummaryDTOAttributeEnum;
use App\Request\SummariseWorkingTimeRequest;

final class OvertimeHoursDecorator implements SummariseWorkingTimeDecoratorInterface
{
    public function decorate(SummaryDTO $summaryDTO, SummariseWorkingTimeRequest $summariseWorkingTimeRequest): void
    {
        $totalHoursAttribute = $summaryDTO->getAttribute(SummaryDTOAttributeEnum::TOTAL_HOURS->value);

        $totalHours = 0;

        if ($totalHoursAttribute instanceof AttributeDTO) {
            $totalHours = (int)$totalHoursAttribute->value;
        }

        $overtimeHours = $totalHours - $summariseWorkingTimeRequest->getMonthlyWorkingHoursQuota();

        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::OVERTIME_HOURS->value, max($overtimeHours, 0));
    }
}
