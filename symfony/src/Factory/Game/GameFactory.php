<?php

declare(strict_types=1);

namespace App\Factory\Game;

use App\Entity\Game;
use App\Model\Game\Board;
use App\Model\Game\Status;
use Ramsey\Uuid\Uuid;

class GameFactory implements GameFactoryInterface
{
    public function create(Board $board): Game
    {
        return new Game(Uuid::uuid4(), $board, Status::RUNNING);
    }
}
