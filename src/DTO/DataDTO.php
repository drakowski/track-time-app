<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\HttpFoundation\Response;

final class DataDTO
{
    private int $status = Response::HTTP_OK;

    public function __construct(
        private readonly ?array $data = null,
        private readonly ?string $message = null,
    ) {
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
