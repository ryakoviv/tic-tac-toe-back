<?php

declare(strict_types=1);

namespace App\Service\Shared;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ConstraintViolationListNormalizer implements NormalizerInterface
{
    /**
     * @param object $object
     * @param string $format
     * @param array $context
     * @return array
     */
    public function normalize($object, string $format = null, array $context = array()): array
    {
        [$messages, $violations] = $this->getMessagesAndViolations($object);
        return [
            'title' => $context['title'] ?? 'An error occurred',
            'detail' => $messages ? implode("\n", $messages) : '',
            'violations' => $violations,
        ];
    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @return array
     */
    private function getMessagesAndViolations(ConstraintViolationListInterface $constraintViolationList): array
    {
        $violations = $messages = [];
        /** @var ConstraintViolation $violation */
        foreach ($constraintViolationList as $violation) {
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
                'code' => $violation->getCode(),
            ];
            $propertyPath = $violation->getPropertyPath();
            $messages[] = ($propertyPath ? $propertyPath.': ' : '').$violation->getMessage();
        }
        return [$messages, $violations];
    }

    /**
     * @param mixed $data
     * @param string $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof ConstraintViolationListInterface;
    }
}
