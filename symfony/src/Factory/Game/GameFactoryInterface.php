<?php

declare(strict_types=1);

namespace App\Factory\Game;

use App\Entity\Game;
use App\Model\Game\Board;

interface GameFactoryInterface
{
    public function create(Board $board): Game;
}
