<?php

namespace App\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseFormatter
{
    private mixed $data = null;
    private string $message = 'OK';
    private array $errors = [];
    private int $statusCode = Response::HTTP_OK;
    private array $additionalData = [];

    public function withData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function withMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function withErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function withStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function withAdditionalData(array $additionalData): self
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    public function getResponse(): JsonResponse
    {
        return new JsonResponse([
            'statusCode' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors,
            'additionalData' => $this->additionalData,
        ], $this->statusCode);
    }
}
