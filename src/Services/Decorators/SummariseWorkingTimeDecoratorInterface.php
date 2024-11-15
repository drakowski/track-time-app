<?php

declare(strict_types=1);

namespace App\Services\Decorators;

use App\DTO\SummaryDTO;
use App\Request\SummariseWorkingTimeRequest;

interface SummariseWorkingTimeDecoratorInterface
{
    public function decorate(SummaryDTO $summaryDTO, SummariseWorkingTimeRequest $summariseWorkingTimeRequest): void;
}
