<?php

declare(strict_types=1);

namespace App\Services\Decorators;

use App\DTO\Attribute\AttributeDTO;
use App\DTO\SummaryDTO;
use App\Enum\SummaryDTOAttributeEnum;
use App\Request\SummariseWorkingTimeRequest;

final class TotalPaymentForHoursDecorator implements SummariseWorkingTimeDecoratorInterface
{
    public function decorate(SummaryDTO $summaryDTO, SummariseWorkingTimeRequest $summariseWorkingTimeRequest): void
    {
        $standardPaymentForHoursAttribute = $summaryDTO->getAttribute(SummaryDTOAttributeEnum::STANDARD_PAYMENT_FOR_HOURS->value);

        $standardPaymentForHours = 0;

        if ($standardPaymentForHoursAttribute instanceof AttributeDTO) {
            $standardPaymentForHours = $standardPaymentForHoursAttribute->value;
        }

        $overtimePaymentForHoursAttribute = $summaryDTO->getAttribute(SummaryDTOAttributeEnum::OVERTIME_PAYMENT_FOR_HOURS->value);

        $overtimePaymentForHours = 0;

        if ($overtimePaymentForHoursAttribute instanceof AttributeDTO) {
            $overtimePaymentForHours = $overtimePaymentForHoursAttribute->value;
        }

        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::TOTAL_PAYMENT_FOR_HOURS->value, $standardPaymentForHours + $overtimePaymentForHours);
    }
}
