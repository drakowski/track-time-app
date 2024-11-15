<?php

declare(strict_types=1);

namespace App\DTO\Attribute;
final readonly class AttributeDTO
{
    public function __construct(public string $key, public mixed $value)
    {
    }
}