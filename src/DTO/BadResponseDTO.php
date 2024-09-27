<?php

namespace App\DTO;

readonly class BadResponseDTO
{
    /**
     * @param bool $status
     * @param array $errors
     */
    public function __construct(
        private bool $status = true,
        private array $errors = [],
    ) {
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}