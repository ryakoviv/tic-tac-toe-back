<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

abstract class AbstractController extends AbstractFOSRestController
{
    protected function validateRequest(Request $httpRequest)
    {
        if ($httpRequest->getContentType() !== 'json') {
            throw new UnsupportedMediaTypeHttpException();
        }
    }

    protected function getBody(Request $httpRequest): array
    {
        $this->validateRequest($httpRequest);

        return json_decode($httpRequest->getContent(), true) ?? [];
    }
}
