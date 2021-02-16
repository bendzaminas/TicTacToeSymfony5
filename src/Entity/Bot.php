<?php

namespace App\Entity;

class Bot
{
    /*
     * @var string
     */
    public const PLAYER_UNIT = 'o';

    /*
     * @return string
     */
    public function getUnit(): string
    {
        return self::PLAYER_UNIT;
    }
}
