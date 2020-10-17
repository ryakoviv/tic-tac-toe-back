<?php

declare(strict_types=1);

namespace App\UseCase\Game;

use App\Factory\Game\BoardFactoryInterface;
use App\Factory\Game\GameResponseFactoryInterface;
use App\Repository\Game\GameRepositoryInterface;
use App\Request\Game\MoveGameRequest;
use App\Response\Game\GameResponse;
use App\Service\Game\ArbiterInterface;
use App\Service\Game\BotPlayer;
use Ramsey\Uuid\Uuid;

class MoveGameUseCase
{
    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    /**
     * @var GameResponseFactoryInterface
     */
    private $gameResponseFactory;

    /**
     * @var BoardFactoryInterface
     */
    private $boardFactory;

    /**
     * @var BotPlayer
     */
    private $botPlayer;

    /**
     * @var ArbiterInterface
     */
    private $arbiter;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        GameResponseFactoryInterface $gameResponseFactory,
        BoardFactoryInterface $boardFactory,
        BotPlayer $botPlayer,
        ArbiterInterface $arbiter
    )
    {
        $this->gameRepository = $gameRepository;
        $this->gameResponseFactory = $gameResponseFactory;
        $this->boardFactory = $boardFactory;
        $this->botPlayer = $botPlayer;
        $this->arbiter = $arbiter;
    }

    public function move(MoveGameRequest $request): GameResponse
    {
        $uuid = Uuid::fromString($request->getGameId());
        $game = $this->gameRepository->getOneById($uuid);
        $board = $this->boardFactory->createFromString($request->getBoard());
        $this->arbiter->validateMove($game->getBoard(), $board);
        $game->setBoard($board);
        $this->arbiter->checkGameStatus($game);
        $this->botPlayer->move($game);
        $this->arbiter->checkGameStatus($game);
        $this->gameRepository->persist($game);

        return $this->gameResponseFactory->createGameResponse($game);
    }
}
