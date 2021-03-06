<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Response\Game\StartGameResponse;
use App\UseCase\Game\StartGameUseCase;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StartGameController extends AbstractController
{
    /**
     * @var StartGameUseCase
     */
    private $useCase;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(StartGameUseCase $useCase, ValidatorInterface $validator)
    {
        $this->useCase = $useCase;
        $this->validator = $validator;
    }

    /**
     * @Rest\Post(path="/api/v1/games")
     * @Rest\View(statusCode=201)
     */
    public function execute(Request $httpRequest): StartGameResponse
    {
        $this->validateRequest($httpRequest);

        return $this->useCase->start();
    }
}
