<?php

declare(strict_types=1);

namespace App\Response\Game;

class GameResponse
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $board;

    /**
     * @var string
     */
    private $status;

    public function __construct(string $id, string $board, string $status)
    {
        $this->id = $id;
        $this->board = $board;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBoard(): string
    {
        return $this->board;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
