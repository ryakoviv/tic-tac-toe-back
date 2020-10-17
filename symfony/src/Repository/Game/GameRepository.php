<?php

declare(strict_types=1);

namespace App\Repository\Game;

use App\Entity\Game\Game;
use App\Exception\Game\GameNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class GameRepository extends ServiceEntityRepository implements GameRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function persist(Game $game): void
    {
        $this->getEntityManager()->persist($game);
        $this->getEntityManager()->flush();
    }

    public function findOneById(UuidInterface $uuid): ?Game
    {
        return $this->find($uuid);
    }

    public function getOneById(UuidInterface $uuid): Game
    {
        $game = $this->findOneById($uuid);
        if (!$game) {
            throw new GameNotFoundException(sprintf('game with id %s is not found', $uuid->toString()));
        }

        return $game;
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function remove(Game $game): void
    {
        $this->getEntityManager()->remove($game);
        $this->getEntityManager()->flush();
    }
}
