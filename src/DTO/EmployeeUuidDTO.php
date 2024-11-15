<?php

declare(strict_types=1);

namespace App\DTO;

readonly class EmployeeUuidDTO implements DTOInterface
{
    public function __construct(private string $uuid)
    {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
