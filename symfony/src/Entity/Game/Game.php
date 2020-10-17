<?php

namespace App\Entity\Game;

use App\Model\Game\Board;
use App\Model\Game\Status;
use App\Repository\Game\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="board")
     */
    private $board;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $status;

    public function __construct(UuidInterface $id, Board $board, string $status)
    {
        Status::assertAllowedValue($status);
        $this->id = $id;
        $this->board = $board;
        $this->status = $status;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        Status::assertAllowedValue($status);
        $this->status = $status;

        return $this;
    }

    public function setBoard(Board $board): self
    {
        $this->board = $board;

        return $this;
    }

    public function isOver()
    {
        return ($this->status === Status::DRAW || $this->status === Status::X_WON || $this->status === Status::O_WON);
    }
}
