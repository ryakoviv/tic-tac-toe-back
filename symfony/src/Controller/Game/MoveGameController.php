<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Exception\BadRequestException;
use App\Request\Game\MoveGameRequest;
use App\Response\Game\GameResponse;
use App\UseCase\Game\MoveGameUseCase;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MoveGameController extends AbstractController
{
    /**
     * @var MoveGameUseCase
     */
    private $useCase;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(MoveGameUseCase $useCase, ValidatorInterface $validator)
    {
        $this->useCase = $useCase;
        $this->validator = $validator;
    }

    /**
     * @Rest\Put(path="/api/v1/games/{gameId}")
     * @Rest\View()
     */
    public function execute(string $gameId, Request $httpRequest): GameResponse
    {
        $this->validateRequest($httpRequest);

        $request = (new MoveGameRequest())->setGameId($gameId);
        $body = $this->getBody($httpRequest);
        if (isset($body['board'])) {
            $request->setBoard($body['board']);
        }

        $validationErrors = $this->validator->validate($request);
        if (\count($validationErrors) > 0) {
            throw BadRequestException::fromValidation($validationErrors);
        }

        return $this->useCase->move($request);
    }
}
