<?php

declare(strict_types=1);

namespace App\Services\Decorators;

use App\DTO\SummaryDTO;
use App\Enum\SummaryDTOAttributeEnum;
use App\Request\SummariseWorkingTimeRequest;

final class EmployeeUuidDecorator implements SummariseWorkingTimeDecoratorInterface
{
    public function decorate(SummaryDTO $summaryDTO, SummariseWorkingTimeRequest $summariseWorkingTimeRequest): void
    {
        $summaryDTO->addAttribute(SummaryDTOAttributeEnum::EMPLOYEE_UUID->value, $summariseWorkingTimeRequest->getEmployeeUuid());
    }
}
