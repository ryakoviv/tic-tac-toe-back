<?php

declare(strict_types=1);

namespace App\Service\Game;

use App\Entity\Game\Game;

interface BotPlayer
{
    public function move(Game $game): void;
}
