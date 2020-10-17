<?php

declare(strict_types=1);

namespace App\Service\Game;

use App\Factory\Game\GameResponseFactoryInterface;
use App\Repository\GameRepositoryInterface;

class GetGamesService
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
