<?php

namespace App\Service;

class GameService
{
    public const BOARD_SIZE = 3;
    public const BOT_UNIT = 'o';

    private function checkRowsColumns(array $board, string $player): bool
    {
        $markedCount = null;
        foreach ($board as $row) {
            $markedCount = count(array_keys($row, $player));
            if ($markedCount === self::BOARD_SIZE) {
                return true;
            }
        }
        return false;
    }

    private function checkDiagonal(array $board, string $player): bool
    {
        $marksCount = null;
        foreach ($board as $y => $row) {
            foreach ($row as $x => $value) {
                if ($y === $x) {
                    ($board[$y][$x] === $player) ? $marksCount += 1 : false;
                }
            }
        }
        if ($marksCount === self::BOARD_SIZE) {
            return true;
        }
        return false;
    }

    private function isWinner(array $board, string $player): bool
    {
        return (
            $this->checkRowsColumns($board, $player) ||
            $this->checkRowsColumns(array_map(null, ...$board), $player) ||
            $this->checkDiagonal($board, $player) ||
            $this->checkDiagonal(array_reverse($board), $player)
        ) ?: false;
    }
    public function getEmptyCells($board): array
    {
        $emptyCells = [];
        foreach ($board as $y => $row) {
            $rowKeys = array_keys($row, '');
            foreach ($rowKeys as $cell) {
                array_push($emptyCells, ['y' => $y, 'x' => $cell]);
            }
        }
        return $emptyCells;
    }

    private function botMove(array $board): array
    {
        $emptyCells = $this->getEmptyCells($board);
        $botMove = $emptyCells[array_rand($emptyCells)] + ['unit' => self::BOT_UNIT];
        return $botMove;
    }

    public function play(array $board, string $player): array
    {
        // check human move
        if ($this->isWinner($board, $player)) {
            return $winner = [
                'winner' => [
                    'unit' => $player,
                    'moves' => [],
                ],
            ];
        }
        // empty cells left?
        if (count($this->getEmptyCells($board)) <1) {
            return [
                'draw' => true,
                'botMove' => [],
            ];
        }
        // Bot moves
        $botMove = $this->botMove($board);
        $board[$botMove['y']][$botMove['x']] = self::BOT_UNIT;
        // check Bots move
        if ($this->isWinner($board, self::BOT_UNIT)) {
            return $winnerBot = [
                'winner' => [
                    'unit' => self::BOT_UNIT,
                    'moves' => [],
                ],
                'botMove' => $botMove,
            ];
        }
        return ['botMove' => $botMove];
    }
}
