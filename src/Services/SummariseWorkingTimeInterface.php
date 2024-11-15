<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\SummaryDTO;
use App\Request\SummariseWorkingTimeRequest;

interface SummariseWorkingTimeInterface
{
    public function summarise(SummariseWorkingTimeRequest $summariseWorkingTimeRequest): SummaryDTO;
}
