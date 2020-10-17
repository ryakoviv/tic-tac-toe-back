<?php

declare(strict_types=1);

namespace App\Request\Game;

use Symfony\Component\Validator\Constraints as Assert;

class MoveGameRequest
{
    /**
     * @Assert\NotBlank
     * @Assert\Uuid()
     * @var string
     */
    private $gameId;

    /**
     * @Assert\NotBlank
     * @var string
     */
    private $board;

    public function setGameId(string $gameId): self
    {
        $this->gameId = $gameId;

        return $this;
    }

    public function getGameId(): string
    {
        return $this->gameId;
    }

    public function setBoard(string $board): self
    {
        $this->board = $board;

        return $this;
    }

    public function getBoard(): string
    {
        return $this->board;
    }
}
