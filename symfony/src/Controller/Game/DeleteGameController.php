<?php

declare(strict_types=1);

namespace App\Controller\Game;

use App\Controller\AbstractController;
use App\Exception\BadRequestException;
use App\Request\Game\DeleteGameRequest;
use App\UseCase\Game\DeleteGameUseCase;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeleteGameController extends AbstractController
{
    /**
     * @var DeleteGameUseCase
     */
    private $useCase;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(DeleteGameUseCase $useCase, ValidatorInterface $validator)
    {
        $this->useCase = $useCase;
        $this->validator = $validator;
    }

    /**
     * @Rest\Delete(path="/api/v1/games/{gameId}")
     * @Rest\View()
     */
    public function execute(string $gameId, Request $httpRequest): void
    {
        $this->validateRequest($httpRequest);

        $request = (new DeleteGameRequest())->setGameId($gameId);
        $validationErrors = $this->validator->validate($request);
        if (\count($validationErrors) > 0) {
            throw BadRequestException::fromValidation($validationErrors);
        }
        $this->useCase->delete($request);
    }
}
