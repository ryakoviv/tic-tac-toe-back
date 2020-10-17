<?php

declare(strict_types=1);

namespace App\Service\Game;

use App\Entity\Game;
use App\Model\Game\Board;

interface ArbiterInterface
{
    public function checkGameStatus(Game $game): void;

    public function validateMove(Board $prevBoard, Board $newBoard): void;
}
