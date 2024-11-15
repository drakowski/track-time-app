<?php

declare(strict_types=1);

namespace App\Services\Decorators;

use App\DTO\Attribute\AttributeDTO;
use App\DTO\SummaryDTO;
use App\Enum\SummaryDTOAttributeEnum;
use App\Request\SummariseWorkingTimeRequest;

final class OvertimePaymentForHoursDecorator implements SummariseWorkingTimeDecoratorInterface
{
    public function decorate(SummaryDTO $summaryDTO, SummariseWorkingTimeRequest $summariseWorkingTimeRequest): void
    {
        $overtimeHoursAttribute = $summaryDTO->getAttribute(SummaryDTOAttributeEnum::OVERTIME_HOURS->value);

        $overtimeHours = 0;

        if ($overtimeHoursAttribute instanceof AttributeDTO) {
            $overtimeHours = (int)$overtimeHoursAttribute->value;
        }

        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::OVERTIME_PAYMENT_FOR_HOURS->value, $overtimeHours * ($summariseWorkingTimeRequest->getHourlyRate() * $summariseWorkingTimeRequest->getHourlyOvertimeRatePercent()) / 100);
    }
}
