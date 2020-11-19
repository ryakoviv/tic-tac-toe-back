<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory\Game;


use App\Factory\Game\BoardFactoryInterface;
use App\Factory\Game\BoardFactory;
use App\Model\Game\Board;
use PHPUnit\Framework\TestCase;

class BoardFactoryTest extends TestCase
{
    /** @var BoardFactoryInterface */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new BoardFactory();
    }

    public function testCreateFromStringSuccessful()
    {
       $board = $this->factory->createEmptyBoard();
       $this->assertInstanceOf(Board::class, $board);
    }
}
