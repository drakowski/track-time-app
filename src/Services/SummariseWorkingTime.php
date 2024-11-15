<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\SummaryDTO;
use App\Request\SummariseWorkingTimeRequest;
use App\Services\Decorators\SummariseWorkingTimeDecoratorInterface;

readonly class SummariseWorkingTime implements SummariseWorkingTimeInterface
{
    public function __construct(private iterable $decorators)
    {

    }

    public function summarise(SummariseWorkingTimeRequest $summariseWorkingTimeRequest): SummaryDTO
    {
        $summaryDTO = new SummaryDTO();
        /** @var SummariseWorkingTimeDecoratorInterface $decorator */
        foreach ($this->decorators as $decorator) {
            $decorator->decorate($summaryDTO, $summariseWorkingTimeRequest);
        }


        return $summaryDTO;
    }
}
