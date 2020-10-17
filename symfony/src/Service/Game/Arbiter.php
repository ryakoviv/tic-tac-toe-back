<?php

declare(strict_types=1);

namespace App\Service\Game;

use App\Entity\Game\Game;
use App\Exception\Game\InvalidMoveException;
use App\Model\Game\Board;
use App\Model\Game\Status;

class Arbiter implements ArbiterInterface
{
    private const WON_REGEX = '/(^%1$s{3})|(%1$s{3}$)|(.{3}%1$s{3}.{3})|((%1$s.{2}){3})|((.%1$s.{1}){3})|((.{2}%1$s){3})|(%1$s.{3}%1$s.{3}%1$s)|(.{2}%1$s.%1$s.%1$s.{2})/';

    public function validateMove(Board $prevBoard, Board $newBoard): void
    {
        $prevBoardString = $prevBoard->get();
        $newBoardString = $newBoard->get();
        $length = strlen($prevBoardString);
        $newValueSet = null;
        for ($i=0; $i<$length; $i++) {
            if ($prevBoardString[$i] !== $newBoardString[$i]) {
                if ($newBoardString[$i] === Board::CELL_EMPTY ) {
                    throw new InvalidMoveException(sprintf('Cell cannot be cleared'));
                }

                if ($prevBoardString[$i] === Board::CELL_O || $prevBoardString[$i] === Board::CELL_X) {
                    throw new InvalidMoveException(sprintf('Cell is already filled and cannot be changed'));
                }

                if ($newValueSet !== null) {
                    throw new InvalidMoveException(sprintf('Only one cell can be changed per move'));
                }

                $newValueSet = $newBoardString[$i];
            }
        }

        if ($newValueSet === null) {
            throw new InvalidMoveException(sprintf('No changes detected, one cell must be changed in each move'));
        }

        if ($newValueSet !== $this->getNextMoveValue($prevBoard)) {
            throw new InvalidMoveException(sprintf('It is not turn for "%s"', $newValueSet));
        }
    }

    public function checkGameStatus(Game $game): void
    {
        if ($this->isXWon($game->getBoard())) {
            $game->setStatus(Status::X_WON);
            return;
        }

        if ($this->isOWon($game->getBoard())) {
            $game->setStatus(Status::O_WON);
            return;
        }

        if ($this->boardHasEmptyCell($game->getBoard())) {
            $game->setStatus(Status::RUNNING);
            return;
        }

        $game->setStatus(Status::DRAW);
    }

    private function boardHasEmptyCell(Board $board): bool
    {
        return (bool)$this->countCellsOnBoard($board, Board::CELL_EMPTY);
    }

    private function isXWon(Board $board): bool
    {
        return (bool)preg_match(sprintf(self::WON_REGEX, Board::CELL_X), $board->get());
    }

    private function isOWon(Board $board): bool
    {
        return (bool)preg_match(sprintf(self::WON_REGEX, Board::CELL_O), $board->get());
    }

    private function getNextMoveValue(Board $board): string
    {
        $x = $this->countCellsOnBoard($board, Board::CELL_X);
        $o = $this->countCellsOnBoard($board, Board::CELL_O);

        if ($x === $o) {
            return $this->getFirstMoveValue();
        }

        if ($x > $o) {
            return Board::CELL_O;
        }

        return Board::CELL_X;
    }

    private function countCellsOnBoard(Board $board, string $cellValue): int
    {
        return preg_match(sprintf('/%s/', $cellValue), $board->get());
    }

    private function getFirstMoveValue(): string
    {
        return Board::CELL_X;
    }
}
