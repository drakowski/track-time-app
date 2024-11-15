<?php

declare(strict_types=1);

namespace App\Services\Decorators;

use App\DTO\SummaryDTO;
use App\Enum\SummaryDTOAttributeEnum;
use App\Request\SummariseWorkingTimeRequest;

final class OvertimeRateDecorator implements SummariseWorkingTimeDecoratorInterface
{
    public function decorate(SummaryDTO $summaryDTO, SummariseWorkingTimeRequest $summariseWorkingTimeRequest): void
    {
        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::OVERTIME_RATE->value, $summariseWorkingTimeRequest->getHourlyOvertimeRatePercent());
    }
}
