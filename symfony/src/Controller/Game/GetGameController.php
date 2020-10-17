<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Exception\BadRequestException;
use App\Request\Game\GetGameRequest;
use App\Response\Game\GameResponse;
use App\UseCase\Game\GetGameUseCase;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetGameController extends AbstractController
{
    /**
     * @var GetGameUseCase
     */
    private $useCase;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(GetGameUseCase $useCase, ValidatorInterface $validator)
    {
        $this->useCase = $useCase;
        $this->validator = $validator;
    }

    /**
     * @Rest\Get(path="/api/v1/games/{gameId}")
     * @Rest\View()
     */
    public function execute(string $gameId, Request $httpRequest): GameResponse
    {
        $this->validateRequest($httpRequest);

        $request = (new GetGameRequest())->setGameId($gameId);
        $validationErrors = $this->validator->validate($request);
        if (\count($validationErrors) > 0) {
            throw BadRequestException::fromValidation($validationErrors);
        }

        return $this->useCase->get($request);
    }
}
