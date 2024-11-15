<?php

declare(strict_types=1);

namespace App\Services\Decorators;

use App\DTO\Attribute\AttributeDTO;
use App\DTO\SummaryDTO;
use App\Enum\SummaryDTOAttributeEnum;
use App\Request\SummariseWorkingTimeRequest;

final class StandardPaymentForHoursDecorator implements SummariseWorkingTimeDecoratorInterface
{
    public function decorate(SummaryDTO $summaryDTO, SummariseWorkingTimeRequest $summariseWorkingTimeRequest): void
    {
        $standardHoursAttribute = $summaryDTO->getAttribute(SummaryDTOAttributeEnum::STANDARD_HOURS->value);

        $standardHours = 0;

        if ($standardHoursAttribute instanceof AttributeDTO) {
            $standardHours = (int)$standardHoursAttribute->value;
        }

        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::STANDARD_PAYMENT_FOR_HOURS->value, $standardHours * $summariseWorkingTimeRequest->getHourlyRate());
    }
}
