<?php

declare(strict_types=1);

namespace App\Request\Game;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteGameRequest
{
    /**
     * @Assert\NotBlank
     * @Assert\Uuid()
     * @var string
     */
    private $gameId;

    public function setGameId(string $gameId): self
    {
        $this->gameId = $gameId;

        return $this;
    }

    public function getGameId(): string
    {
        return $this->gameId;
    }
}
