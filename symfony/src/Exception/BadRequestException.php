<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class BadRequestException extends \RuntimeException
{
    public static function fromValidation(ConstraintViolationListInterface $validationErrors): self
    {
        return new self($validationErrors[0]->getPropertyPath() . ': ' . $validationErrors[0]->getMessage());
    }
}
