<?php

declare(strict_types=1);

namespace App\Request\Game;
use Symfony\Component\Validator\Constraints as Assert;

class StartGameRequest
{
    /**
     * @Assert\NotBlank
     * @var string
     */
    private $board;

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
