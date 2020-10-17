<?php

declare(strict_types=1);

namespace App\Service\Game;

use App\Repository\GameRepositoryInterface;
use App\Request\Game\DeleteGameRequest;
use Ramsey\Uuid\Uuid;

class DeleteGameService
{
    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    public function __construct(GameRepositoryInterface $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function delete(DeleteGameRequest $request): void
    {
        $uuid = Uuid::fromString($request->getGameId());
        $game = $this->gameRepository->getOneById($uuid);
        $this->gameRepository->remove($game);
    }
}
