<?php

declare(strict_types=1);

namespace App\Factory\Game;

use App\Model\Game\Board;

interface BoardFactoryInterface
{
    public function createFromString(string $board): Board;

    public function createEmptyBoard(): Board;
}
