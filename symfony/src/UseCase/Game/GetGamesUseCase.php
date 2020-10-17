<?php

declare(strict_types=1);

namespace App\UseCase\Game;

use App\Factory\Game\GameResponseFactoryInterface;
use App\Repository\Game\GameRepositoryInterface;

class GetGamesUseCase
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

    public function get(): array
    {
        $games = $this->gameRepository->findAll();

        return $this->gameResponseFactory->createArrayResponse($games);
    }
}
