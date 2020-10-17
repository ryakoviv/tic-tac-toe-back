<?php

declare(strict_types=1);

namespace App\Type\Game;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Uuid;

class UuidType extends Type
{
    const NAME = 'uuid';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'uuid';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Uuid::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->toString();
    }

    public function getName()
    {
        return self::NAME;
    }
}
