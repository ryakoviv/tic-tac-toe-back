<?php

declare(strict_types=1);

namespace App\Model;

namespace App\Model\Game;

use App\Exception\Game\InvalidStatusException;

class Status
{
    public const RUNNING = 'RUNNING';
    public const X_WON = 'X_WON';
    public const O_WON = 'O_WON';
    public const DRAW = 'DRAW';

    /** @var string[] */
    public static $all = [self::RUNNING, self::X_WON, self::O_WON, self::DRAW];

    public static function assertAllowedValue(string $status): void
    {
        if (!\in_array($status, self::$all)) {
            throw new InvalidStatusException(
                sprintf(
                    'Status "%s" is not supported, allowed values: %s',
                    $status,
                    implode(',', self::$all)
                )
            );
        }
    }
}
