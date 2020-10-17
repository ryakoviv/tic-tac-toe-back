<?php

declare(strict_types=1);

namespace App\Type\Game;

use App\Model\Game\Board;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class BoardType extends Type
{
    const NAME = 'board';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'board';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Board($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->get();
    }

    public function getName()
    {
        return self::NAME;
    }
}
