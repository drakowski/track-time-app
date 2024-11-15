<?php

declare(strict_types=1);

namespace App\Services;

use App\Request\RegisterWorkingTimeRequest;

interface RegisterWorkingTimeServiceInterface
{
    public function register(string $employeeUuid, RegisterWorkingTimeRequest $registerWorkingTimeRequest): void;
}
