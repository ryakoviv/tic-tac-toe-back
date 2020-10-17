<?php

declare(strict_types=1);

namespace App\Factory\Game;

use App\Model\Game\Board;

class BoardFactory implements BoardFactoryInterface
{
    public function createFromString(string $board): Board
    {
        return new Board($board);
    }

    public function createEmptyBoard(): Board
    {
        return $this->createFromString($this->boardGenerator());
    }

    private function boardGenerator(): string
    {
        $board = '';
        for ($i = 0; $i < Board::CELL_NUMBER; $i++) {
            $board .= Board::CELL_EMPTY;
        }

        return $board;
    }
}
