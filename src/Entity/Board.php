<?php

namespace App\Entity;

class Board
{
    public const BOARD_SIZE = 3;
    private array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function getSize(): int
    {
        return self::BOARD_SIZE;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getEmptyCells(): array
    {
        $emptyCells = [];
        foreach ($this->content as $y => $row) {
            $rowKeys = array_keys($row, '');
            foreach ($rowKeys as $cell) {
                array_push($emptyCells, ['y' => $y, 'x' => $cell]);
            }
        }
        return $emptyCells;
    }

    public function setMove(array $move): void
    {
        $this->content[$move['y']][$move['x']] = $move['unit'];
        return;
    }
}
