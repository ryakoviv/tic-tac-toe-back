<?php

declare(strict_types=1);

namespace App\UseCase\Game;

use App\Factory\Game\GameResponseFactoryInterface;
use App\Repository\Game\GameRepositoryInterface;
use App\Request\Game\GetGameRequest;
use App\Response\Game\GameResponse;
use Ramsey\Uuid\Uuid;

class GetGameUseCase
{
    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    /**
     * @var GameResponseFactoryInterface
     */
    private $gameResponseFactory;

    public function __construct(GameRepositoryInterface $gameRepository, GameResponseFactoryInterface $gameResponseFactory)
    {
        $this->gameRepository = $gameRepository;
        $this->gameResponseFactory = $gameResponseFactory;
    }

    public function get(GetGameRequest $request): GameResponse
    {
        $uuid = Uuid::fromString($request->getGameId());
        $game = $this->gameRepository->getOneById($uuid);

        return $this->gameResponseFactory->createGameResponse($game);
    }
}
