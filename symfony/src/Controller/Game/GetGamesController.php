<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\UseCase\Game\GetGamesUseCase;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class GetGamesController extends AbstractController
{
    /**
     * @var GetGamesUseCase
     */
    private $useCase;

    public function __construct(GetGamesUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @Rest\Get(path="/api/v1/games")
     * @Rest\View()
     */
    public function execute(Request $httpRequest): array
    {
        $this->validateRequest($httpRequest);

        return $this->useCase->get();
    }
}
