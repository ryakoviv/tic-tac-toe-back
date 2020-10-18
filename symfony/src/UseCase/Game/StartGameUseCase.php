<?php

declare(strict_types=1);

namespace App\UseCase\Game;

use App\Factory\Game\BoardFactoryInterface;
use App\Factory\Game\GameFactoryInterface;
use App\Factory\Game\GameResponseFactoryInterface;
use App\Repository\Game\GameRepositoryInterface;
use App\Response\Game\StartGameResponse;
use App\Service\Game\ArbiterInterface;
use App\Service\Game\BotPlayer;

class StartGameUseCase
{
    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    /**
     * @var GameFactoryInterface
     */
    private $gameFactory;

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
        GameFactoryInterface $gameFactory,
        GameResponseFactoryInterface  $gameResponseFactory,
        BoardFactoryInterface $boardFactory,
        BotPlayer $botPlayer,
        ArbiterInterface $arbiter
    ) {
        $this->gameRepository = $gameRepository;
        $this->gameFactory = $gameFactory;
        $this->gameResponseFactory = $gameResponseFactory;
        $this->boardFactory = $boardFactory;
        $this->botPlayer = $botPlayer;
        $this->arbiter = $arbiter;
    }

    public function start(): StartGameResponse
    {
        $board = $this->boardFactory->createEmptyBoard();
        $game = $this->gameFactory->create($board);
        $this->gameRepository->persist($game);

        return $this->gameResponseFactory->createStartGameResponse($game);
    }
}
