<?php

declare(strict_types=1);

namespace App\DTO\Attribute\Traits;

use App\DTO\Attribute\AttributeDTO;

trait AttributeTrait
{
    private array $attributes = [];

    public function getAttribute(string $key): ?AttributeDTO
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->key === $key) {
                return $attribute;
            }
        }

        return null;
    }

    public function addAttribute(string $key, mixed $value): void
    {
        $this->attributes[] = new AttributeDTO($key, $value);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
