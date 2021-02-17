<?php

namespace App\Entity;

class Bot implements PlayerInterface
{
    public const UNIT = 'o';

    public function getUnit(): string
    {
        return self::UNIT;
    }

    public function move(object $board): array
    {
        $emptyCells = $board->getEmptyCells();
        return $emptyCells[array_rand($emptyCells)] + ['unit' => self::UNIT];
    }
}
