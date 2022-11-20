<?php

declare(strict_types=1);

namespace App\Validator\Result;

class ValidatorResult
{
    private array $errors = [];

    public function appendError(string $error)
    {
        $this->errors[] = $error;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}