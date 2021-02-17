<?php

namespace App\Service;

use App\Entity\Bot;
use App\Entity\Board;
use App\Entity\PlayerInterface;

class PlayService
{
    private function checkRowsColumns(Board $board, PlayerInterface $player): bool
    {
        $reversedContent = [$board->getContent(), array_map(null, ...($board->getContent()))];
        foreach ($reversedContent as $content) {
            $markedCount = null;
            foreach ($content as $row) {
                $markedCount = count(array_keys($row, $player->getUnit()));
                if ($markedCount === $board->getSize()) {
                    return true;
                }
            }
        }
        return false;
    }

    private function checkDiagonal(Board $board, PlayerInterface $player): bool
    {
        $reversedContent = [$board->getContent(), array_reverse($board->getContent())];
        foreach ($reversedContent as $content) {
            $marksCount = null;
            foreach ($content as $y => $row) {
                foreach ($row as $x => $value) {
                    if ($y === $x) {
                        ($content[$y][$x] === $player->getUnit()) ? $marksCount += 1 : false;
                    }
                }
            }
            if ($marksCount === $board->getSize()) {
                return true;
            }
        }
        return false;
    }

    private function isWinner(Board $board, PlayerInterface $player): bool
    {
        return ($this->checkRowsColumns($board, $player) || $this->checkDiagonal($board, $player)) ?: false;
    }

    public function play(Board $board, PlayerInterface $player, array $botMove = []): array
    {
        // check human move
        if ($this->isWinner($board, $player)) {
            return $winner = [
                'winner' => [
                    'unit' => $player->getUnit(),
                    'moves' => [],
                ],
                'botMove' => $botMove,
            ];
        }
        // empty cells left?
        if (count($board->getEmptyCells()) < 1) {
            return [
                'draw' => true,
                'botMove' => [],
            ];
        }
        if ($player instanceof Bot) {
            return ['botMove' => $botMove];
        }
        return [];
    }
}
