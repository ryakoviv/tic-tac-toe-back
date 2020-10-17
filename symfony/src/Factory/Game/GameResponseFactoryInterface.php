<?php

declare(strict_types=1);

namespace App\Factory\Game;

use App\Entity\Game\Game;
use App\Response\Game\GameResponse;
use App\Response\Game\StartGameResponse;

interface GameResponseFactoryInterface
{
    /**
     * @param Game[] $games
     * @return GameResponse[]
     */
    public function createArrayResponse(array $games): array;

    public function createGameResponse(Game $game): GameResponse;

    public function createStartGameResponse(Game $game): StartGameResponse;
}
