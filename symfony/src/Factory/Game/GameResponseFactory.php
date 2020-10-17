<?php

declare(strict_types=1);

namespace App\Factory\Game;

use App\Entity\Game\Game;
use App\Response\Game\GameResponse;
use App\Response\Game\StartGameResponse;

class GameResponseFactory implements GameResponseFactoryInterface
{
    public function createGameResponse(Game $game): GameResponse
    {
        return new GameResponse($game->getId()->toString(), $game->getBoard()->get(), $game->getStatus());
    }

    public function createArrayResponse(array $games): array
    {
        $response = [];
        foreach ($games as $game) {
            $response[] = $this->createGameResponse($game);
        }

        return $response;
    }

    public function createStartGameResponse(Game $game): StartGameResponse
    {
        return new StartGameResponse($game->getId()->toString());
    }
}
