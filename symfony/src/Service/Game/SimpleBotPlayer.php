<?php

declare(strict_types=1);

namespace App\Service\Game;

use App\Entity\Game;
use App\Model\Game\Board;

class SimpleBotPlayer implements BotPlayer
{
    public function getSide(): string
    {
        return Board::CELL_O;
    }

    public function move(Game $game): void
    {

        if ($game->isOver()) {
            return;
        }

        $stringBoard = $game->getBoard()->get();
        $length = strlen($stringBoard);
        for ($i=0; $i<$length; $i++) {
            if ($stringBoard[$i] === Board::CELL_EMPTY) {
                $stringBoard[$i] = $this->getSide();
                break;
            }
        }

        $game->setBoard(new Board($stringBoard));
    }
}
