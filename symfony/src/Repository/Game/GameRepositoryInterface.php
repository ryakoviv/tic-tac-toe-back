<?php

declare(strict_types=1);

namespace App\Repository\Game;

use App\Entity\Game\Game;
use Ramsey\Uuid\UuidInterface;

interface GameRepositoryInterface
{
    public function persist(Game $game): void;

    public function findOneById(UuidInterface $uuid): ?Game;

    public function getOneById(UuidInterface $uuid): Game;

    public function findAll(): array;

    public function remove(Game $game): void;
}
