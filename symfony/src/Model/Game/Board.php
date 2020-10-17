<?php

declare(strict_types=1);

namespace App\Model\Game;

use App\Exception\Game\InvalidBoardException;

class Board
{
    const CELL_X = 'X';
    const CELL_O = 'O';
    const CELL_EMPTY = '-';
    const CELL_NUMBER = 9;

    /**
     * @var string
     */
    private $board;

    public function __construct(string $board)
    {
        $this->validate($board);
        $this->board = $board;
    }

    public function get(): string
    {
        return $this->board;
    }

    private function validate(string $board): void
    {
        if (!preg_match($this->getValidationRegex(), $board)) {
            throw new InvalidBoardException(sprintf('board "%s" is not valid', $board));
        }
    }

    private function getValidationRegex(): string
    {
        return sprintf('/^[%s%s%s]{%d}$/', self::CELL_X, self::CELL_O, self::CELL_EMPTY, self::CELL_NUMBER);
    }
}
