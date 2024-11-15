<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\BaseDTO;
use App\DTO\DataDTO;
use App\DTO\DTOInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    protected function json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        if ($data instanceof DataDTO) {
            $data->setStatus($status);
        }

        return parent::json($data, $status, $headers, $context);
    }

    protected function prepareDataDTO(DTOInterface|array|null $baseDTO = null, ?string $message = null): DataDTO
    {
        if (is_array($baseDTO)) {
            return new DataDTO($baseDTO, $message);
        }

        return new DataDTO($baseDTO ? [$baseDTO] : null, $message);
    }

    protected function error(string $message): JsonResponse
    {
        return $this->json($this->prepareDataDTO(message: $message), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
